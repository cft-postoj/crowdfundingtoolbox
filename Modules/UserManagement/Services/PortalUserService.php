<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Repositories\PortalUserRepository;

class PortalUserService implements PortalUserServiceInterface
{

    private $portalUserRepository;

    public function __construct(PortalUserRepository $portalUserRepository)
    {
        $this->portalUserRepository = $portalUserRepository;
    }

    public function getPortalUsers()
    {
        try {
            return $this->portalUserRepository->all();
        } catch (\Exception $exception) {
            return \response()->json([
                'error' => $exception
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function getPortalUserById()
    {
        // TODO: Implement getPortalUserById() method.
    }
}