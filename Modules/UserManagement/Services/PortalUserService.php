<?php


namespace Modules\UserManagement\Services;


use Carbon\Carbon;
use const http\Client\Curl\Features\HTTP2;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Modules\UserManagement\Emails\AutoRegistrationEmail;
use Modules\UserManagement\Emails\ForgottenPasswordEmail;
use Modules\UserManagement\Jobs\RemoveGeneratedToken;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserCookieCouple;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserRepository;

class PortalUserService implements PortalUserServiceInterface
{

    private $userRepository;
    private $portalUserRepository;
    private $generatedUserTokenRepository;
    private $usernameUsedCounter;
    private $generatedTokenJob;
    private $generatedUserTokenService;

    public function __construct(PortalUserRepository $portalUserRepository,
                                UserRepository $userRepository,
                                GeneratedUserTokenRepository $generatedUserTokenRepository,
                                RemoveGeneratedToken $generatedTokenJob)
    {
        $this->portalUserRepository = $portalUserRepository;
        $this->userRepository = $userRepository;
        $this->generatedUserTokenRepository = $generatedUserTokenRepository;
        $this->generatedTokenJob = $generatedTokenJob;
        $this->usernameUsedCounter = 0;
    }

    public function getAll()
    {
        try {
            return $this->userRepository->getPortalUsers();
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getById($id)
    {
        try {
            return $this->userRepository->getPortalUserById($id);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request)
    {
        $valid = validator($request->only(
            'email',
            'password'
        ), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:6'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }


        try {
            $email = $request['email'];
            $user = $this->userRepository->getByEmail($email);
            $existInUserTable = ($user !== null) ? true : false;
            $existInPortalUserTable = ($user === null) ? false :
                (($this->portalUserRepository->get($user->id) !== null) ? true : false);
            if ($existInUserTable && $existInPortalUserTable) {
                return \response()->json([
                    'error' => array(
                        'type' => 'email-registered',
                        'message' => 'Email is already registered.'
                    )
                ], Response::HTTP_BAD_REQUEST);
            } else if ($existInUserTable && !$existInPortalUserTable) {
                /*
                 * in this case, user is registered as backoffice user and want to register as portal user with
                 * the same email address
                 */
                $this->portalUserRepository->create($user->id);
                // update user password
                $this->userRepository->updatePassword($user->id, $request['password']);

                return \response()->json([
                    'message' => 'Account was successfully created.'
                ], Response::HTTP_CREATED);
            }
            /*
             * create new user
             */

            $username = explode('@', $request['email'])[0];
            $newUserId = $this->userRepository->create($request['email'], $request['password'], $this->checkUniqueUsername($username));
            $portalUser = $this->portalUserRepository->create($newUserId);
            $this->userRepository->coupleUserWithCookie($portalUser->id, intval($request['user_cookie']));
            return \response()->json([
                'message' => 'Account was successfully created.'
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            $error = array(
                'type' => 'undefined',
                'message' => 'There was an error during the registration process.'
            );

            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $error = array(
                    'type' => 'email',
                    'message' => 'Email is not correct.'
                );
            }
            return \response()->json([
                'error' => $error
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function checkToken()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $loggedIn = false;

        if ($user->id !== null) {
            $loggedIn = true;
        }

        return \response()->json([
            'isLoggedIn' => $loggedIn
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return \response()->json([
            'status' => 'logout',
            'message' => 'Token was successfully invalidated.'
        ], Response::HTTP_OK);
    }

    private function checkUniqueUsername($username)
    {
        if ($this->userRepository->isUsernameUsed($username) === null) {
            return $username;
        }
        $this->usernameUsedCounter++;
        return $this->checkUniqueUsername($username . $this->usernameUsedCounter);
    }

    public function getUserByToken()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->id !== null) {
            return \response()->json([
                $this->portalUserRepository->get($user->id)
            ], Response::HTTP_OK);
        }

        return \response()->json([
            'error' => 'unauthorized'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function authenticate($request)
    {
        $prefix = $request->route()->getPrefix();
        /*
         * check if there is portal endpoint (not for backoffice users)
         */
        if (strpos($prefix, 'backoffice') !== false) {
            return \response()->json([
                'error' => 'invalid_access',
                'message' => 'You don\'t have an access to this.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->only('email', 'password');

        // if user post username
        if (strpos($request['email'], '@') === false) {
            $credentials = [
                'username' => $request['email'],
                'password' => $request['password']
            ];
        }
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $possibleUser = $this->userRepository->getByEmail($request['email']);
                if ($possibleUser !== null) {
                    // check if user exist like Portal user
                    if ($this->portalUserRepository->get($possibleUser->id) !== null) {
                        return \response()->json([
                            'error' => true,
                            'type' => 'password'
                        ], Response::HTTP_BAD_REQUEST);
                    }
                }
                return \response()->json([
                    'error' => true,
                    'type' => 'email'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (JWTException $e) {
            return \response()->json(['error' => 'could_not_create_token', 'message' => $e], 500);
        }

        $user = Auth::user();
        $portalUser = PortalUser::where('user_id',$user->id)->select('id')->first();
        $this->coupleUserIdAndUserCookie($portalUser->id, $request['user_cookie']);
        $token = JWTAuth::fromUser($user);
        return \response()->json([
            'token' => $token
        ], Response::HTTP_OK);
    }

    public function resetPassword($request)
    {
        try {
            $this->generatedUserTokenService = new GeneratedUserTokenService();
            $possibleUser = $this->userRepository->getByEmail($request['email']);
            if ($possibleUser !== null) {
                // check if user exist like Portal user
                if ($this->portalUserRepository->get($possibleUser->id) !== null) {
                    Mail::to($request['email'])->send(new ForgottenPasswordEmail($this->generatedUserTokenService->create($possibleUser->id)));
                    return \response()->json([
                        'error' => false,
                        'message' => 'Email with password was successfully sent.'
                    ], Response::HTTP_OK);
                }
            }
            return \response()->json([
                'error' => true,
                'type' => 'email'
            ], Response::HTTP_BAD_REQUEST);

        } catch (JWTException $e) {
            return \response()->json(['error' => 'could_not_create_token', 'message' => $e], Response::HTTP_BAD_REQUEST);
        }
    }


        public function registerDuringDonation(String $email, int $cookie): User
    {
        //find user by email. if email is already in database, don't create new user but return that user
        $userByMail = User::where('email', $email)->first();
        if ($userByMail) {
            return $userByMail;
        }
        $generatedPassword = $this->generatePasswordToken();

        $username = explode('@', $email)[0];
        $user = User::create([
            'email' => $email,
            'username' => $username,
            'password' => bcrypt($generatedPassword),
            'generate_password_token' => $generatedPassword
        ]);

        $user->portalUser = PortalUser::create([
            'user_id' => $user->id
        ]);

        $user->portalUser->userCookieCouple = $this->coupleUserIdAndUserCookie($cookie, $user['id']);

        Mail::to($email)->send(new AutoRegistrationEmail($username, $generatedPassword));

        return $user;
    }

    public function coupleUserIdAndUserCookie($userId, $cookieId): UserCookieCouple
    {
        return UserCookieCouple::create([
            'user_cookie_id' => $cookieId,
            'portal_user_id' => $userId
        ]);
    }
}