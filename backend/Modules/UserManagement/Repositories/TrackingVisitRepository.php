<?php


namespace Modules\UserManagement\Repositories;

use Modules\UserManagement\Entities\TrackingVisit;

class TrackingVisitRepository implements TrackingVisitRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = TrackingVisit::class;
    }

    public function all()
    {
        return $this->model
            ::all();
    }

    public function getCountInSpecificDateByUser($portal_user_id, $date)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->whereDate('created_at', '>=', $date)
            ->toSql();
    }
}