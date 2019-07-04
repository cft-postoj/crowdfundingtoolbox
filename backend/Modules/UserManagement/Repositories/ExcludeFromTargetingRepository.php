<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\ExcludeUserFromCampaign;

class ExcludeFromTargetingRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = ExcludeUserFromCampaign::class;
    }

    public function create($portalUserId, $reason)
    {
        return $this->model
            ::create([
                'portal_user_id' => $portalUserId,
                'reason_notes' => $reason
            ]);
    }

    public function delete($portalUserId)
    {
        return $this->model
            ::where('portal_user_id', $portalUserId)
            ->delete();
    }
}