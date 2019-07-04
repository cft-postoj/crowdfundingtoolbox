<?php


namespace Modules\UserManagement\Repositories;


use http\Env\Response;
use Modules\UserManagement\Entities\UserCookieCouple;
use Modules\UserManagement\Entities\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    function __construct()
    {
        $this->model = User::class;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function get($id)
    {
        return $this->model
            ::where('id', $id)
            ->first();
    }

    public function updatePassword($id, $pasword)
    {
        return $this->model
            ::where('id', $id)
            ->update([
                'password' => bcrypt($pasword)
            ]);
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getPortalUsers()
    {
        return $this->model
            ::has('portalUser')
            ->has('userDetail')
            ->with('userDetail')
            ->with('portalUser')
            ->with('portalUser.isMonthlyDonor')
            ->with('portalUser.excludeFromCampaign')
            ->with('portalUser.userPaymentOptions')
            ->get();
    }

    public function getPortalUserById($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('userDetail')
            ->with('donorStatus')
            ->with('portalUser.donations')
            ->with('portalUser.variableSymbol')
            ->with('portalUser.isMonthlyDonor')
            ->with('portalUser.excludeFromCampaign')
            ->with('portalUser.userPaymentOptions')
            ->first();
    }

    public function create($email, $password, $username)
    {
        $user = $this->model
            ::create([
                'email' => $email,
                'password' => bcrypt($password),
                'username' => $username
            ]);
        $user->save();
        return $user->id;
    }

    public function isUsernameUsed($username)
    {
        return $this->model
            ::where('username', $username)
            ->first();
    }

    public function addGeneratedToken($id, $token)
    {
        return $this->model
            ::where('id', $id)
            ->update([
                'generate_password_token' => $token
            ]);
    }

    public function coupleUserWithCookie($newUserId, $user_cookie)
    {
        return UserCookieCouple::create([
            'user_cookie_id' => $user_cookie,
            'portal_user_id' => $newUserId
        ]);
    }

    public function update($request, $user_id)
    {
        return $this->model
            ::where('id', $user_id)
            ->update($request);
    }

    public function createUserDetail($user_id)
    {
        return $this->model
            ::where('id', $user_id)
            ->userDetail()
            ->create();
    }
}