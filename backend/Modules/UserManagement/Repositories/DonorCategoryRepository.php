<?php

namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\DonorCategory;

class DonorCategoryRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = DonorCategory::class;
    }

    public function get()
    {
        return $this->model::orderBy('min_value', 'desc')->get();
    }

}