<?php

namespace Modules\Payment\Entities;


use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetType;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Entities\UserDetail;

class DonationFilter extends ModelFilter
{
    public function setup()
    {
        $this
            ->leftJoinSub(PortalUser::query()->select('id as portal_user_id', 'user_id'),
                'portal_user_query', 'donations.portal_user_id', '=', 'portal_user_query.portal_user_id')
            ->leftJoinSub(User::query()->select('id as user_id', 'email'),
                'user_query', 'portal_user_query.user_id', '=', 'user_query.user_id')
            ->leftJoinSub(UserDetail::query()->select('id as user_detail_id', 'user_id', 'first_name', 'last_name'),
                'user_detail_query', 'user_query.user_id', '=', 'user_detail_query.user_id')
//            // join campaign
            ->leftJoinSub(Widget::query()->select('id as widget_id', 'campaign_id', 'widget_type_id'),
                'widget_query', 'donations.widget_id', '=', 'widget_query.widget_id')
            ->leftJoinSub(Campaign::query()->select('id as campaign_id', 'name as campaign_name'),
                'campaign_query', 'widget_query.campaign_id', '=', 'campaign_query.campaign_id')
//            //join widgetType
            ->leftJoinSub(WidgetType::query()->select('id as widget_type_id'),
                'widget_type_query', 'widget_query.widget_type_id', '=', 'widget_type_query.widget_type_id')
//            //join paymentMethod
            ->leftJoinSub(Payment::query()->select('id as payment_id', 'transaction_id', 'transfer_type', 'iban', 'variable_symbol','transaction_date','created_by'),
                'payment_query', 'donations.payment_id', '=', 'payment_query.payment_id')
            ->leftJoinSub(PaymentMethod::query()->select('id as payment_method_id', 'method_name as payment_method_name'),
                'payment_method_query', 'payment_query.transfer_type', '=', 'payment_method_query.payment_method_id')
        ;
    }

    public function orderIban($asc)
    {
        return $this->orderBy(DB::raw("\"iban\""), $asc);
    }

    public function iban($value)
    {
        return $this->whereLike('iban', $value);
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

    public function orderAmount($asc)
    {
        return $this->orderBy(DB::raw("\"amount\""), $asc);
    }

    public function minAmount($value)
    {
        return $this->where('amount', '>=', $value);
    }

    public function maxAmount($value)
    {
        return $this->where('amount', '<=', $value);
    }

    public function orderTransactionDate($value)
    {
        return $this->orderBy(DB::raw("\"payment_query\".\"transaction_date\""), $value);
    }

    public function campaignName($value)
    {
        return $this->whereLike('campaign_name', $value);
    }

    public function orderCampaignName($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"campaign_name\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"campaign_name\" DESC NULLS LAST"));
    }

    public function orderFullname($asc)
    {
        return $this->orderBy(DB::raw("CONCAT(first_name,' ',last_name)"), $asc);
    }

    public function fullName($value)
    {
        return $this->whereLike(DB::raw("CONCAT(first_name,' ',last_name)"), $value);

    }

    public function orderTransaction($value)
    {
        return $this->orderBy(DB::raw("\"transaction_id\""), $value);
    }

    public function transaction($value)
    {
        return $this->whereLike('transaction_id', $value);

    }

    public function orderEmail($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"email\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"email\" DESC NULLS LAST"));
    }

    public function email($value)
    {
        return $this->whereLike("email", $value);

    }

    public function orderUser($asc)
    {
        return $this->orderBy(DB::raw("\"portal_user_query\".\"user_id\""), $asc);
    }

    public function minUser($value)
    {
        return $this->where('portal_user_query.user_id', '>=', $value);
    }

    public function maxUser($value)
    {
        return $this->where('portal_user_query.user_id', '<=', $value);
    }

    public function user($value)
    {
        return $this->where('portal_user_query.user_id', $value);
    }


    public function orderIsMonthlyDonation($value)
    {
        return $this->orderBy(DB::raw("\"is_monthly_donation\""), $value);
    }

    public function orderCreatedBy($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"payment_query\".\"created_by\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"payment_query\".\"created_by\" DESC NULLS LAST"));
    }

    public function orderCreatedAt($value)
    {
        return $this->orderBy("created_at", $value);
    }

    public function createdBy($value)
    {
        return $this->whereLike("payment_query.created_by", $value);

    }

    public function orderPaymentMethodName($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"payment_method_name\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"payment_method_name\" DESC NULLS LAST"));
    }

    public function paymentMethodName($value)
    {
        return $this->whereLike("payment_method_name", $value);
    }

    public function orderDonation($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"donation_id\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"donation_id\" DESC NULLS LAST"));
    }

    public function status($value)
    {
        return $this->whereLike("status", $value);
    }

    public function orderStatus($value)
    {
        return $this->orderBy(DB::raw("\"status\""), $value);
    }

    public function orderPayment($value)
    {
        return $this->orderBy(DB::raw("\"payment_query\".\"payment_id\""), $value);
    }

}