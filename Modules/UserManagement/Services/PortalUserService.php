<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Repositories\UserRepository;

class PortalUserService implements PortalUserServiceInterface
{

    private $userRepository;
    private $portalUserRepository;

    public function __construct(PortalUserRepository $portalUserRepository, UserRepository $userRepository)
    {
        $this->portalUserRepository = $portalUserRepository;
        $this->userRepository = $userRepository;
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
                'error' =>  $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}