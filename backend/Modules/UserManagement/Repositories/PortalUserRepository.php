<?php


namespace Modules\UserManagement\Repositories;


use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\PortalUser;

class PortalUserRepository implements PortalUserRepositoryInterface
{
    protected $model;

    function __construct()
    {
        $this->model = PortalUser::class;
    }

    public function all()
    {
        return $this->model
            ::with('donations')
            ->with('isMonthlyDonor')
            ->get();
    }

    public function get($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->first();
    }

    public function update($request, $portal_user_id)
    {
        return $this->model
            ::where('id', $portal_user_id)
            ->update($request);
    }


    public function create($userId)
    {
        return $this->model
            ::create([
                'user_id' => $userId
            ]);
    }

    public function getDonationsByUserPortalAndDate($id, $from, $to)
    {
        return Donation::query()
            ->whereHas('portalUser', function ($join) use ($id) {
                $join->where('user_id', $id);
            })
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('widget.campaign')
            ->with('widget.widgetType')
            ->with('portalUser.user.userDetail')
            ->with('payment.paymentMethod')
            ->get();
    }

    public function getAllWithDonations()
    {
        return $this->model
            ::has('donations')
            ->with('donations')
            ->has('user')
            ->with('user.userDetail')
            ->with('visit')
            ->get();
    }

    public function getDonationsDetailInfo($id)
    {
        return $this->model
            ::where('user_id', $id)
            ->with(['firstDonation', 'last', 'isMonthlyDonor', 'donationsSum'])
            ->first();
    }

}