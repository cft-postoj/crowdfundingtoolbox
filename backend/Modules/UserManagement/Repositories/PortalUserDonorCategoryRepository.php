<?php

namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\PortalUserDonorCategory;

class PortalUserDonorCategoryRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = PortalUserDonorCategory::class;
    }

    public function createMass($data)
    {
        return $this->model::create($data);
    }

    public function getById($id)
    {
        return $this->model::where('id', $id)
            ->with('donorCategory')
            ->orderByDesc('valid_from')
            ->first();
    }

    public function getByPortalUserId($portalUserId)
    {
        return $this->model::where('portal_user_id', $portalUserId)
            ->whereHas('donorCategory')
            ->with('donorCategory')
            ->orderByDesc('valid_from')
            ->get();
    }

    public function update($category)
    {
        return $category->save();
    }

    public function delete($portalUserCategory)
    {
        return $portalUserCategory->delete();
    }


}