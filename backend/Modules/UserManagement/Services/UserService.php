<?php


namespace Modules\UserManagement\Services;


use http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Modules\UserManagement\Entities\BackOfficeUser;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\ServiceAccount;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserCookie;
use Modules\UserManagement\Repositories\UserRepository;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $usernameUsedCounter = 0;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getById($id)
    {
        return $this->userRepository->get($id);
    }

    public function createCookieIfNew($ip)
    {
        $agent = new Agent();
        $deviceType = 'not detected';
        if ($agent->isDesktop()) {
            $deviceType = 'desktop';
        } elseif ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isPhone()) {
            $deviceType = 'phone';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        } elseif ($agent->isTablet()) {
            $deviceType = 'robot';
        }

        return UserCookie::create([
            'device_type' => $deviceType,
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'languages' => implode(" ", $agent->languages()),
            'ip' => $ip,
        ]);
    }

    public function createServiceAccount($data)
    {

        $username = $this->checkUniqueUsername(isset($data['username'])
            ? $data['username'] : explode('@', $data['email'])[0]);

        $user = $this->userRepository->getByEmail($data['email']);
        $existInUserTable = ($user === null) ? false : true;

        if (!$existInUserTable) {
            $user = User::create([
                'username' => $username,
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
        }
        ServiceAccount::create(['user_id' => $user->id]);
        Log::info('service account with email ' . $data['email'] . ' successfully created');
    }

    public function create($request)
    {
        $prefix = $request->route()->getPrefix();

        $valid = validator($request->only(
            'email',
            //'username',
            'first_name',
            'last_name',
            'password'
        ), [
            'email' => 'required|string|email|max:255|unique:users',
            // 'username' => 'string|max:255|unique:users',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'password' => 'required|string|max:255'
        ]);

        if ($valid->fails()) {
            /* TODO: pridat podmienku pre situaciu, kedy uz pouzivatel existuje, no nie ako portal user alebo backoffice - teda email/username is exist */
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {

            $data = \request()->only('email', 'username', 'password');

            $username = $this->checkUniqueUsername(isset($data['username'])
                ? $data['username'] : explode('@', $data['email'])[0]);

            $user = $this->userRepository->getByEmail($data['email']);
            $existInUserTable = ($user === null) ? false : true;

            if (!$existInUserTable) {
                $user = User::create([
                    'username' => $username,
                    'email' => $data['email'],
                    'password' => bcrypt($data['password'])
                ]);
                $user->save();
            }


            if (strpos($prefix, 'backoffice') !== false) {
                $currentAdmin = Auth::user();
                if (BackOfficeUser::where('user_id', $currentAdmin->id)->first()->only('role_id')['role_id'] == 1) {
                    $backOfficeUser = BackOfficeUser::create([
                        'user_id' => $user->id,
                        'role_id' => ($request['role'] === 'admin') ? 1 : 2   // admin / manager user
                    ]);
                    $backOfficeUser->save();
                } else {
                    return response()->json([
                        'message' => 'You don\'t have permissions to this action'
                    ], 400);
                }
            } else {
                PortalUser::create([
                    'user_id' => $user->id
                ])->save();
                Mail::to($data['email'])->send(new RegisterEmail());
            }

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $user;
    }

    private function checkUniqueUsername($username)
    {
        if ($this->userRepository->isUsernameUsed($username) === null) {
            return $username;
        }
        $this->usernameUsedCounter++;
        return $this->checkUniqueUsername($username . $this->usernameUsedCounter);
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getUserByEmailWithUserPaymentOptions(string $email)
    {
        return $this->userRepository->getUserByEmailWithUserPaymentOptions($email);
    }

    public function isBackofficeUser($id)
    {
        return $this->userRepository->isBackofficeUser($id);
    }

    public function isServiceAccount($id)
    {
        return $this->userRepository->isServiceAccount($id);
    }

    public function userHaveValidAddress($userDetail) : bool
    {
        if ($userDetail == null) {
            return false;
        }
        return !empty($userDetail->first_name) && !empty($userDetail->last_name) &&
            !empty($userDetail->street) && !empty($userDetail->street) && !empty($userDetail->city);
    }

}