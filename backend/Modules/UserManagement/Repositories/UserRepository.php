<?php


namespace Modules\UserManagement\Repositories;


use Illuminate\Support\Facades\DB;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserCookieCouple;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    function __construct()
    {
        $this->model = User::class;
    }

    public function getAll()
    {
        return $this->model
            ->all();
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
        return User::where('email', $email)->with('portalUser.variableSymbol')->first();
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

    public function findByString($string)
    {
        return $this->model
            ::select(['id', 'email'])
            ->has('portalUser')
            ->whereHas('userDetail', function ($query) use ($string) {
                $query->where(DB::raw("CONCAT(first_name,' ',last_name)"), 'ILIKE', '%' . $string . '%');
            })
            ->orWhere('email','LIKE', '%'.$string.'%')
            ->with(['userDetail:id,user_id,first_name,last_name', 'portalUser'])
            ->limit(100)
            ->get();
    }

    public function getPortalUserById($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('userDetail')
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

    public function coupleUserWithCookie($newPortalUserId, $user_cookie)
    {
        return UserCookieCouple::create([
            'user_cookie_id' => $user_cookie,
            'portal_user_id' => $newPortalUserId
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

    public function getUserByEmail(string $email)
    {
        return User
            ::where('email', $email)
            ->with('portalUser.variableSymbol')
            ->get();
    }

    public function getUserByEmailWithUserPaymentOptions(string $email)
    {
        return User
            ::where('email', $email)
            ->with('portalUser.userPaymentOptions')
            ->first();
    }

    public function getWithVariableSymbol($userId)
    {
        return $this->model
            ::where('id', $userId)
            ->with('portalUser.variableSymbol')
            ->first();
    }

    public function isBackofficeUser($userId)
    {
        return User::query()
            ->where('id', $userId)
            ->has('backOfficeUser')
            ->exists();
    }
    public function isServiceAccount($userId)
    {
        return User::query()
            ->where('id', $userId)
            ->has('serviceAccount')
            ->exists();
    }

}
