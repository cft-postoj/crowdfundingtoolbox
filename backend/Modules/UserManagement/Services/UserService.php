<?php


namespace Modules\UserManagement\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Modules\UserManagement\Entities\BackOfficeUser;
use Modules\UserManagement\Entities\PortalUser;
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

    public function createCookieIfNew($userCookie, $userId, $ip)
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

        if ($userCookie == "" && $userId == null) {
            return UserCookie::create([
                'device_type' => $deviceType,
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'languages' => implode(" ", $agent->languages()),
                'ip' => $ip,
            ]);
        }
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

        $data = \request()->only('email', 'username', 'password');

        $username = $this->checkUniqueUsername(isset($data['username'])
            ? $data['username'] : explode('@', $data['email'])[0]);

        $user = User::create([
            'username' => $username,
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $user->save();

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

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user
        ], 201);
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
}