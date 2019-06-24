<?php


namespace Modules\Targeting\Services;


use Illuminate\Http\Response;
use Modules\UserManagement\Services\PortalUserService;

class CampaignTargetingService implements CampaignTargetingServiceInterface
{
    private $portalUserService;

    public function __construct(PortalUserService $portalUserService)
    {
        $this->portalUserService = $portalUserService;
    }

    public function getUsersCount($request)
    {
        $countUsers = 0;
        $countVisitors = 0;
        try {
            $signed_status = $request['signed_status']['signed']['active'];
            $notsigned_status = $request['signed_status']['not_signed']['active'];
            $one_time_supporter = $request['support']['one_time']['active'];
            $monthly_supporter = $request['support']['monthly']['active'];

            if ($signed_status) {
                $users = $this->portalUserService->getAll();
                $countUsers = sizeof($users);
                // TODO make this -- DONATIONS
            }

            if ($notsigned_status) {
                $countVisitors = 999999;
            }

        } catch (\Exception $exception) {
            response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'count_users' => $countUsers,
            'count_visitors'    =>  $countVisitors
        ], Response::HTTP_OK);
    }
}