<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\UserDetailRepository;
use JWTAuth;

class UserDetailService implements UserDetailServiceInterface
{
    private $userDetailRepository;

    public function __construct(UserDetailRepository $userDetailRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
    }

    public function getDetailsByToken()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->id !== null) {
            return \response()->json(
                $this->userDetailRepository->get($user->id),
                Response::HTTP_OK);
        }

        return \response()->json([
            'error' => 'unauthorized'
        ], Response::HTTP_BAD_REQUEST);
    }
}