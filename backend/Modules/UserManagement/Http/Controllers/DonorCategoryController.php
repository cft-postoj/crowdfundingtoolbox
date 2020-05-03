<?php
/**
 * Created by IntelliJ IDEA.
 * User: notebook
 * Date: 20. 9. 2019
 * Time: 12:46
 */

namespace Modules\UserManagement\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\DonorCategoryService;
use Modules\UserManagement\Services\PortalUserDonorCategoryService;

class DonorCategoryController extends Controller
{

    private $donorCategoryService;
    private $portalUserDonorCategoryService;

    public function __construct(
        DonorCategoryService $donorCategoryService,
        PortalUserDonorCategoryService $portalUserDonorCategoryService)
    {

        $this->donorCategoryService = $donorCategoryService;
        $this->portalUserDonorCategoryService = $portalUserDonorCategoryService;

    }

    protected function getDonorCategories()
    {
        return \response()->json(
            $this->donorCategoryService->get()
            , Response::HTTP_OK);
    }

    protected function assignDonorCategoryToPortalUser(Request $request)
    {
        $portalUserDonorCategories = $this->portalUserDonorCategoryService->assignDonorCategoryToPortalUser($request['portalUserId'], $request['newCategoryId']);
        return \response()->json([
            'message' => 'User is now in category ' . $portalUserDonorCategories[0]['donorCategory']['name'],
            'portalUserDonorCategories' => $portalUserDonorCategories
        ], Response::HTTP_OK);
    }

    protected function deletePortalUserDonorCategory(Request $request)
    {
        $portalUserDonorCategories = $this->portalUserDonorCategoryService->deletePortalUserDonorCategory($request['id']);
        $message = $portalUserDonorCategories->isEmpty() ?
            'User is now not assigned to any category' :
            'User is now in category ' . $portalUserDonorCategories[0]['donorCategory']['name'];
        return \response()->json([
            'message' => $message,
            'portalUserDonorCategories' => $portalUserDonorCategories
        ], Response::HTTP_OK);
    }


}