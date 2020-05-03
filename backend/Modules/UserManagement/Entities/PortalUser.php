<?php

namespace Modules\UserManagement\Entities;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PortalUser extends Model
{
    use Notifiable, SoftDeletes, Filterable;

    protected $dates = ['deleted_at'];

    protected $table = 'portal_users';

    protected $fillable = [
        'user_id', 'register_by', 'notes'
    ];

    protected $casts = [
        'amount_sum' => 'float',
        'last_donation_value' => 'float'
    ];

    //define class to filter
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\UserManagement\Entities\PortalUserFilter::class);
    }

    public function gdpr()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\UserGdpr');
    }

    public function user()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\User');
    }


    public function visit()
    {
        return $this->hasMany('Modules\UserManagement\Entities\TrackingVisit');
    }

    public function donations()
    {
        return $this->hasMany('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'desc');
    }

    public function lastDonation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->with('payment')
            ->orderBy('created_at', 'DESC');
    }

    public function donationsSum()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->selectRaw('donations.portal_user_id, sum(donations.amount) as donations_sum, count(donations.id) as donations_count')
            ->whereNotNull('payment_id')
            ->groupBy('donations.portal_user_id');
    }

    public function allDonationsByMonth()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->selectRaw('donations.portal_user_id, sum(donations.amount) as donations_sum, count(donations.id) as donations_count')
            ->whereNotNull('payment_id')
            ->groupBy('donations.portal_user_id');
    }

    public function donationsSumInLastYear()
    {
        $now = Carbon::now();
        $lastYear = Carbon::now()->subDays(365);
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->selectRaw('donations.portal_user_id, sum(donations.amount) as donations_sum')
            ->whereNotNull('payment_id')
            ->whereDate('created_at', '>=', $lastYear)
            ->whereDate('created_at', '<=', $now)
            ->groupBy('donations.portal_user_id');
    }

    public function firstDonation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->whereNotNull('payment_id')
            ->with('payment')
            ->join('payments', 'payments.id', '=', 'donations.payment_id')
            ->orderBy('payments.transaction_date')
            ->orderBy('donations.created_at');
    }

    public function lastUserDonation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->whereNotNull('payment_id')
            ->with('payment')
            ->orderBy('created_at', 'DESC');
    }

    public function last()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->whereNotNull('payment_id')
            ->with('payment')
            ->join('payments', 'payments.id', '=', 'donations.payment_id')
            ->orderByDesc('payments.transaction_date')
            ->orderByDesc('donations.created_at');
    }

    public function lastSql()
    {
        return $this->belongsTo('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'DESC')->toSql();
    }

    public function variableSymbol()
    {
        return $this->hasOne('Modules\Payment\Entities\VariableSymbol', 'portal_user_id', 'id');
    }

    public function isMonthlyDonor()
    {
        // SUB DAYS -- count of days from last donation (30 days + 10 days for bank processing)
        $subDays = 30 + 10;
        $today = Carbon::today();
        $minDonationDate = $today->subDays($subDays);
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->join('payments', function ($join) use ($minDonationDate) {
                $join->on('payments.id', '=', 'donations.payment_id')
                    ->where('payments.transaction_date', '>=', $minDonationDate->toDateTimeString());
            })
            ->where('is_monthly_donation', '=', true)
            ->where('status', 'processed')
            ->orderByDesc('payments.transaction_date');

    }

    public function excludeFromCampaign()
    {
        return $this->hasOne('Modules\UserManagement\Entities\ExcludeUserFromCampaign', 'portal_user_id', 'id');
    }

    public function userPaymentOptions()
    {
        return $this->hasOne('Modules\UserManagement\Entities\UserPaymentOption', 'portal_user_id', 'id');
    }

    public function lastPortalUserDonorCategory()
    {
        return $this->hasOne('Modules\UserManagement\Entities\PortalUserDonorCategory', 'portal_user_id', 'id')
            ->orderBy('updated_at');
    }

    public function activeManualAssignedPortalUserDonorCategory()
    {
        return $this->hasOne('Modules\UserManagement\Entities\PortalUserDonorCategory', 'portal_user_id', 'id')
            ->whereDate('valid_to', '<', Carbon::now())
            ->orWhereNull('valid_to')
            ->where('manually_created', true);
    }

    public function getAllDonationsByUser()
    {
        return $this->hasMany('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->whereNotNull('payment_id');
    }

}
