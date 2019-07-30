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

    public function getById($id)
    {
        return $this->model
            ::where('id', $id)
            ->first();
    }

    public function getDetail($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('payment')
            ->with('portalUser')
            ->with('portalUser.user.userDetail')
            ->first();
    }

    public function updateAssignment($portal_user_id, $id)
    {
        return $this->model
            ::where('id', $id)
            ->update(array(
                'portal_user_id' => $portal_user_id
            ));
    }

    public function create($request)
    {
        return $this->model
            ::create(
                $request
            );
    }

    public function delete($id)
    {
        return $this->model
            ::where('id', $id)
            ->delete();
    }
}