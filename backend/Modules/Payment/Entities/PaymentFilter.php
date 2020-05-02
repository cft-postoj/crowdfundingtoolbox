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

class PaymentFilter extends ModelFilter
{
    public function setup()
    {

        $this
            //join UserDetail
            ->leftJoinSub(Donation::query()->select('id as donation_id', 'payment_id as donation_payment_id', 'portal_user_id', 'widget_id', 'is_monthly_donation'),
                'donation_query', 'payments.id', '=', 'donation_query.donation_payment_id')
            ->leftJoinSub(PortalUser::query()->select('id as portal_user_id', 'user_id'),
                'portal_user_query', 'donation_query.portal_user_id', '=', 'portal_user_query.portal_user_id')
            ->leftJoinSub(User::query()->select('id as user_id', 'email'),
                'user_query', 'portal_user_query.user_id', '=', 'user_query.user_id')
            ->leftJoinSub(UserDetail::query()->select('id as user_detail_id', 'user_id', 'first_name', 'last_name'),
                'user_detail_query', 'user_query.user_id', '=', 'user_detail_query.user_id')
            // join campaign
            ->leftJoinSub(Widget::query()->select('id as widget_id', 'campaign_id', 'widget_type_id'),
                'widget_query', 'donation_query.widget_id', '=', 'widget_query.widget_id')
            ->leftJoinSub(Campaign::query()->select('id as campaign_id', 'name as campaign_name'),
                'campaign_query', 'widget_query.campaign_id', '=', 'campaign_query.campaign_id')
            //join widgetType
            ->leftJoinSub(WidgetType::query()->select('id as widget_type_id'),
                'widget_type_query', 'widget_query.widget_type_id', '=', 'widget_type_query.widget_type_id')
            //join paymentMethod
            ->leftJoinSub(PaymentMethod::query()->select('id as payment_method_id', 'method_name as payment_method_name'),
                'payment_query', 'payments.transfer_type', '=', 'payment_query.payment_method_id');

    }

    public function orderIban($asc)
    {
        return $this->orderBy(DB::raw("\"iban\""), $asc);
    }

    public function iban($value)
    {
        return $this->whereLike('iban', $value);
    }

    public function accountName($value)
    {
        return $this->whereLike('account_name', $value);
    }

    public function orderAccountName($asc)
    {
        return $this->orderBy(DB::raw("\"account_name\""), $asc);
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
        return $this->orderBy(DB::raw("\"payments\".\"transaction_date\""), $value);
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
        return $this->orderBy(DB::raw("\"user_query\".\"user_id\""), $asc);
    }

    public function minUser($value)
    {
        return $this->where('user_query.user_id', '>=', $value);
    }

    public function maxUser($value)
    {
        return $this->where('user_query.user_id', '<=', $value);
    }


    public function orderIsMonthlyDonation($value)
    {
        return $this->orderBy(DB::raw("\"is_monthly_donation\""), $value);
    }

    public function orderCreatedBy($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"created_by\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"created_by\" DESC NULLS LAST"));
    }

    public function createdBy($value)
    {
        return $this->whereLike("created_by", $value);

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


    public function donationIsNull($value)
    {
        return $this->whereNull('donation_query.donation_id');
    }

    public function orderDonation($value)
    {
        return $value === 'ASC' ? $this->orderByRaw(DB::raw("\"donation_id\" ASC NULLS FIRST")) :
            $this->orderByRaw(DB::raw("\"donation_id\" DESC NULLS LAST"));
    }

    public function paymentNotes($value)
    {
        return $this->whereLike("payment_notes", $value);

    }

    public function orderPaymentNotes($value)
    {
        return $this->orderBy(DB::raw("\"payment_notes\""), $value);
    }


}
