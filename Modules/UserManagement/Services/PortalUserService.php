<?php


namespace Modules\UserManagement\Services;


use Carbon\Carbon;
use const http\Client\Curl\Features\HTTP2;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Modules\UserManagement\Emails\ForgottenPasswordEmail;
use Modules\UserManagement\Jobs\RemoveGeneratedToken;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserRepository;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

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
            $this->portalUserRepository->create($newUserId);
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
        $token = JWTAuth::fromUser($user);

        //$myPayload = $token->getPayload();
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


}