<?php

namespace Modules\UserManagement\Entities;


use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\Widget;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\VariableSymbol;

class PortalUserFilter extends ModelFilter
{

    public $relations = [
        'user' => ['user_detail']
    ];
    private $firstDonationAt;
    private $firstDonation;
    private $isMonthlyDonor;
    private $donationsSum;
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $isOneTimeDonor;

    public function setup()
    {

        $this->donationsSum = Donation::query()
            ->select('portal_user_id', DB::raw('sum(amount) as amount_sum'))
            ->where('status', 'processed')
            ->groupBy('portal_user_id');


        // SUB DAYS -- count of days from last donation (30 days + 10 days for bank processing)
        $subDays = 30 + 10;
        $today = Carbon::today();

        $this->isMonthlyDonor = Donation::query()
            ->select(DB::raw('DISTINCT ON (portal_user_id) id as monthly_donor_donation_id'), 'portal_user_id as monthly_donor_portal_user_id')
            ->where('is_monthly_donation', '=', true)
            ->where('status', 'processed')
            ->where('created_at', '>=', $today->subDays($subDays)->toDateTimeString());

        $this->isOneTimeDonor = Donation::query()
            ->select(DB::raw('DISTINCT ON (portal_user_id) id as one_time_donor_donation_id'), 'portal_user_id as one_time_donor_portal_user_id')
            ->where('is_monthly_donation', '=', false)
            ->where('status', 'processed')
            ->where('created_at', '>=', $today->subDays($subDays)->toDateTimeString());

        $this->firstDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MIN(created_at) as first_donation_at'))
            ->where('status', 'processed')
            ->groupBy('portal_user_id');

        $this->firstDonation = Donation::query()
            ->select(DB::raw("DISTINCT ON (portal_user_id,created_at) portal_user_id"), 'widget_id as first_donation_widget_id', 'created_at');


        return $this->joinSub(User::query()->select('id as user_id', 'email', 'username'), 'userQuery',
            'portal_users.user_id', '=', 'userQuery.user_id')
            ->leftJoinSub(UserDetail::query()->select('id as user_detail_id','user_id as user_detail_user_id', 'first_name', 'last_name'), 'userDetailQuery',
                'userQuery.user_id', '=', 'userDetailQuery.user_detail_user_id')
            // first donation and date for portal user, when he successfully made first donation
            ->leftJoinSub($this->firstDonationAt, 'first_donation_at', 'portal_users.id', '=', 'first_donation_at.portal_user_id')
            ->leftJoinSub($this->firstDonation, 'first_donation', function ($join) {
                $join->on('first_donation_at', '=', 'first_donation.created_at')
                    ->whereRaw('first_donation.portal_user_id = first_donation_at.portal_user_id');
            })
            ->leftJoinSub(Widget::query()->select(['id as widget_id', 'campaign_id']),
                'first_widget', 'first_donation.first_donation_widget_id', '=', 'first_widget.widget_id')
            ->leftJoinSub(Campaign::query()->select(['id as campaign_id', 'name as campaign_name']),
                'first_campaign', 'first_widget.campaign_id', '=', 'first_campaign.campaign_id')
            ->leftJoinSub(VariableSymbol::query()->select(['portal_user_id', 'variable_symbol as variable_symbol']),
                'variable_symbol_query', 'portal_users.id', '=', 'variable_symbol_query.portal_user_id')
            ->leftJoinSub(UserPaymentOption::query()->select(['portal_user_id', 'bank_account_number']),
                'user_payment_option', 'portal_users.id', '=', 'user_payment_option.portal_user_id')
            ->leftJoinSub($this->isMonthlyDonor, 'isMonthlyDonor',
                'portal_users.id', '=', 'isMonthlyDonor.monthly_donor_portal_user_id')
            ->leftJoinSub($this->isOneTimeDonor, 'isOneTimeDonor',
                'portal_users.id', '=', 'isOneTimeDonor.one_time_donor_portal_user_id')
            ->leftJoinSub($this->donationsSum, 'donations_sum', 'portal_users.id', '=', 'donations_sum.portal_user_id');
    }

    // This will filter 'userId'
    public function user($id)
    {
        return $this->where('user_id', $id);
    }

    public function email($email)
    {
        $this->related('user', function ($query) use ($email) {
            return $query->where('email', 'LIKE', '%' . $email . '%');
        });

    }

    public function orderEmail($asc)
    {
        return $this->orderBy('email', $asc);
    }

    public function orderFullname($asc)
    {
        return $this->orderBy(DB::raw("CONCAT(\"userDetailQuery\".first_name,' ',\"userDetailQuery\".last_name)"), $asc);
    }

    public function fullName($name)
    {
        return $this->related('user', function ($query) use ($name) {
            $query->whereHas('userDetail', function ($query) use ($name) {
                $query->where(DB::raw("CONCAT(first_name,' ',last_name)"), 'LIKE', '%' . $name . '%');
            });
        });
    }


    public function orderAmountSum($asc)
    {
        return $asc === 'ASC' ? $this->orderByRaw(DB::raw("\"donations_sum\".amount_sum ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"donations_sum\".amount_sum DESC NULLS LAST"));
    }

    public function minAmountSum($min)
    {
        return $this->where('donations_sum.amount_sum', '>=', $min);
    }

    public function maxAmountSum($max)
    {
        return $this->where('donations_sum.amount_sum', '<=', $max);
    }

    public function orderLastDonationAt($asc)
    {
        return $this->orderBy("transaction_date", $asc);
    }

    public function orderStatus($asc)
    {
        return $this->orderBy("transaction_date", $asc);
    }

    public function orderUpdatedAt($asc)
    {
        return $this->orderBy("transaction_date", $asc);
    }

    public function campaignName($name)
    {
        return $this->whereLike('campaign_name', $name);
    }

    public function orderCampaignName($asc)
    {
        return $this->orderBy(DB::raw("\"campaign_name\""), $asc);
    }

    public function orderUser($asc)
    {
        return $this->orderBy(DB::raw("\"portal_users\".\"user_id\""), $asc);
    }

    public function minUser($value)
    {
        return $this->where('portal_users.user_id', '>=', $value);
    }

    public function maxUser($value)
    {
        return $this->where('portal_users.user_id', '<=', $value);
    }

    public function orderVariableSymbol($asc)
    {
        return $this->orderBy(DB::raw("\"variable_symbol\""), $asc);
    }

    public function minVariableSymbol($value)
    {
        return $this->where('variable_symbol', '>=', $value);
    }

    public function maxVariableSymbol($value)
    {
        return $this->where('variable_symbol', '<=', $value);
    }

    public function orderBankAccountNumber($asc)
    {
        return $this->orderBy(DB::raw("\"bank_account_number\""), $asc);
    }

    public function bankAccountNumber($value)
    {
        return $this->whereLike('bank_account_number', $value);
    }

    public function orderMonthlyDonorDonation($asc)
    {
        return $this->orderBy(DB::raw("\"monthly_donor_donation_id\""), $asc)->orderby(DB::raw("\"one_time_donor_donation_id\""));
    }

    public function orderRegisterBy($asc)
    {
        return $this->orderBy(DB::raw("\"register_by\""), $asc);
    }


    public function lastDonationPaymentMethodName($name)
    {
        return $this->whereLike('last_donation_payment_method_name', $name);
    }

    public function orderLastDonationPaymentMethodName($asc)
    {
        return $this->orderBy(DB::raw("\"last_donation_payment_method_name\""), $asc);
    }

    public function orderUnlockedAt($asc)
    {
        return $asc === 'ASC' ? $this->orderByRaw(DB::raw('unlocked_at ASC NULLS LAST')) :
            $this->orderByRaw(DB::raw('unlocked_at DESC NULLS LAST'));
    }

}
