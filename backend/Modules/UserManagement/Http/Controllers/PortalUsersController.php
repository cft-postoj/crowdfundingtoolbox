<?php

namespace Modules\UserManagement\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Services\DonorCategoryService;
use Modules\UserManagement\Services\ExcludeFromTargetingService;
use Modules\UserManagement\Services\Export2CsvService;
use Modules\UserManagement\Services\PortalUserDonorCategoryService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\UserService;
use JWTAuth;

class PortalUsersController extends Controller
{
    private $userService;
    private $portalUserService;
    private $excludeFromTargetingService;
    private $export2CsvService;
    private $portalUserDonorCategoryService;
    private $donorCategoryService;

    public function __construct(PortalUserService $portalUserService,
                                Export2CsvService $export2CsvService,
                                UserService $userService,
                                ExcludeFromTargetingService $excludeFromTargetingService,
                                PortalUserDonorCategoryService $portalUserDonorCategoryService,
                                DonorCategoryService $donorCategoryService)
    {
        $this->userService = $userService;
        $this->portalUserService = $portalUserService;
        $this->excludeFromTargetingService = $excludeFromTargetingService;
        $this->export2CsvService = $export2CsvService;
        $this->portalUserDonorCategoryService = $portalUserDonorCategoryService;
        $this->donorCategoryService = $donorCategoryService;
    }

    public function all()
    {
        return \response()->json(
            $this->portalUserService->getAll(),
            Response::HTTP_OK
        );
    }

    public function findByString(Request $request)
    {
        return \response()->json(
            $this->portalUserService->findByString($request['string']),
            Response::HTTP_OK
        );
    }


    public function getById($id)
    {
        return \response()->json(
            $this->portalUserService->getById($id),
            Response::HTTP_OK
        );
    }

    protected function removeById($id)
    {
        return \response()->json(
            $this->portalUserService->removeById($id),
            Response::HTTP_OK
        );
    }

    protected function impersonate($id)
    {
        $user = $this->portalUserService->getById($id);
        $token = JWTAuth::customClaims(['exp' => Carbon::now()->addMinutes(15)->timestamp])->fromUser($user);
        $userWhoIsImpersonating = JWTAuth::parseToken()->authenticate();
        Log::info('user ' . $userWhoIsImpersonating->email . ' is impersonating user with email ' . $user->email);
        return \response()->json(
            ['token' => $token],
            Response::HTTP_OK
        );
    }

    public function create(Request $request)
    {
        return $this->portalUserService->create($request);
    }

    public function isUserLoggedIn()
    {
        return $this->portalUserService->checkToken();
    }

    public function logout()
    {
        return $this->portalUserService->logout();
    }

    protected function authenticate(Request $request)
    {
        return $this->portalUserService->authenticate($request);
    }

    protected function resetPassword(Request $request)
    {
        return $this->portalUserService->resetPassword($request);
    }

    protected function hasUserGeneratedToken(Request $request)
    {
        /* TODO - add method */
        return $this->portalUserService->hasUserGeneratedToken($request);
    }

    protected function excludeFromCampaignsTargeting(Request $request, $portalUserId)
    {
        return $this->excludeFromTargetingService->exclude($request, $portalUserId);
    }

    protected function exportCsv(Request $request)
    {
        return $this->export2CsvService->export($request);
    }

    protected function getDonationsDetailInfo($id)
    {
        return $this->portalUserService->getDonationsDetailInfo($id);
    }

    protected function getPortalUserDonorCategory($id)
    {
        return \response()->json(
            $this->portalUserDonorCategoryService->getByPortalUserId($id)
            , Response::HTTP_OK);
    }

    protected function getDonationsByUserPortalAndDate(Request $request, $id)
    {
        return $this->portalUserService->getDonationsByUserPortalAndDate($id, $request['from'], $request['to']);
    }

    protected function getUserSupportData()
    {
        return \response()->json(
            $this->portalUserService->getUserSupportData(),
            Response::HTTP_OK
        );
    }

    protected function importDonors(Request $request)
    {
        return \response()->json(
            array('donors' => $this->portalUserService->importDonors(),
                'message' => 'Users successfully imported.')
            ,
            Response::HTTP_OK
        );
    }

    protected function importSubscribers(Request $request)
    {
        return \response()->json(
            array('donors' => $this->portalUserService->importSubscribers(),
                'message' => 'Users successfully imported.')
            ,
            Response::HTTP_OK
        );
    }

    protected function importSubscribersSvetKrestanstva(Request $request)
    {
        return \response()->json(
            array('donors' => $this->portalUserService->importSubscribersSvetKrestanstva(),
                'message' => 'Users successfully imported.')
            ,
            Response::HTTP_OK
        );
    }

    protected function getPortalUsers(Request $request)
    {
        return \response()->json(
            $this->portalUserService->getPortalUsers($request['from'], $request['to'], $request['monthly'],
                $request['dataType'], $request['page_size'], $request->all()),
            Response::HTTP_OK
        );
    }

    protected function updatePassword(Request $request)
    {
        return $this->portalUserService->updatePassword($request);
    }

    protected function refreshToken()
    {
        return \response()->json([
            'user_token' => $this->portalUserService->getJWTToken()
        ], Response::HTTP_OK);
    }

}
