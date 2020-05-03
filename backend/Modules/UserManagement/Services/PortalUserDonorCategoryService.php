<?php

namespace Modules\UserManagement\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\Repositories\PortalUserDonorCategoryRepository;

class PortalUserDonorCategoryService
{
    protected $rep;
    private $portalUserService;
    private $donorCategories;
    private $donorCategoryService;

    public function __construct(PortalUserDonorCategoryRepository $rep, DonorCategoryService $donorCategoryService,
                                PortalUserService $portalUserService)
    {
        $this->rep = $rep;
        $this->portalUserService = $portalUserService;
        $this->donorCategoryService = $donorCategoryService;
    }

    public function createMass($data)
    {
        return $this->rep->createMass($data);
    }

    public function getByPortalUserId($id)
    {
        return $this->rep->getByPortalUserId($id);
    }

    public function getById($id)
    {
        return $this->rep->getById($id);
    }

    private function update($user)
    {
        return $this->rep->update($user);
    }


    public function updatePortalUserCategoryAll()
    {
        $usersWithRecentDonation = $this->portalUserService->getUsersWithRecentDonation(30);
        $this->donorCategories = $this->donorCategoryService->get();
        foreach ($usersWithRecentDonation as $user) {
            // update only when category is not manually assigned
            if ($user['activeManualAssignedPortalUserDonorCategory'] === null) {
                $newPortalUserDonorCategory = $this->calcPortalUserDonorCategory($user);
                if ($user['lastPortalUserDonorCategory'] === null) {
                    // if user never was in category, assign him
                    $this->createNewPortalUserDonorCategory($user, $newPortalUserDonorCategory);
                } //if new category is not same as previous, update valid_to in previous assignment and create new assignment to DonorCategory
                elseif ($newPortalUserDonorCategory['id'] !== $user['lastPortalUserDonorCategory']['donor_category_id']) {
                    $user['lastPortalUserDonorCategory']->valid_to = Carbon::now();
                    $this->update($user['lastPortalUserDonorCategory']);
                    $this->createNewPortalUserDonorCategory($user, $newPortalUserDonorCategory);
                }
            }
            //if new category is same as previous, do nothing
        }
    }
//    public function changePortalCategory($user)
//    {
//        return $user['portalUserDonorCategories'] === null;
//
//    }

    private function createNewPortalUserDonorCategory($user, $newPortalUserDonorCategory)
    {
        $this->rep->createMass(['portal_user_id' => $user->id,
            'donor_category_id' => $newPortalUserDonorCategory['id'],
            'valid_from' => Carbon::now(),
            'active' => true,
            'automatically_calculated' => true,
            'manually_created' => false,
            'created_by']);

    }

    //calc what DonorCategory should user acquire
    private function calcPortalUserDonorCategory($user)
    {
        //calc sum of donation
        $donationSum = $user['donations']->pluck('amount')->sum();
        //find first donorCategory, where $donationSum is bigger or equal as DonorCategory min_value and smaller than max_value

        $result = $this->donorCategories->first(function ($value, $key) use ($donationSum) {
            return $donationSum >= $value['min_value'];
        });
        return $result;
    }

    public function assignDonorCategoryToPortalUser($portalUserId, $newCategoryId)
    {
        $portalUserCategories = $this->getByPortalUserId($portalUserId);

        $this->rep->createMass(['portal_user_id' => $portalUserId,
            'donor_category_id' => $newCategoryId,
            'valid_from' => Carbon::now(),
            'active' => true,
            'automatically_calculated' => false,
            'manually_created' => true,
            'created_by' => Auth::user()->id]);

        foreach ($portalUserCategories as $category) {
            if ($category->valid_to === null) {
                $category->valid_to = Carbon::now();
                $category->active = false;
                $this->rep->update($category);
            }
        }

        return $this->getByPortalUserId($portalUserId);

    }

    public function deletePortalUserDonorCategory($id)
    {

        $objectToRemove = $this->getById($id);
        $this->delete($objectToRemove);

        return $this->getByPortalUserId($objectToRemove['portal_user_id']);
    }

    private function delete($objectToRemove)
    {
        $this->rep->delete($objectToRemove);
    }


}