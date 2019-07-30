<?php


namespace Modules\UserManagement\Repositories;


interface TrackingVisitRepositoryInterface
{
    public function all();
    public function getCountInSpecificDateByUser($portal_user_id, $date);
}