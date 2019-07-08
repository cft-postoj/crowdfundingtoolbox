<?php


namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\Donation;

class DonationRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Donation::class;
    }

    public function getDetail($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('payments')
            ->with('portalUser')
            ->with('portalUser.user.userDetail')
            ->first();
    }
}