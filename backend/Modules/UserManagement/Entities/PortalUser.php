<?php

namespace Modules\UserManagement\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PortalUser extends Model
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'portal_users';

    protected $fillable = [
        'user_id'
    ];

    protected $casts = [
        'amount_sum' => 'float',
        'last_donation_value' => 'float'
    ];

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
//            ->selectRaw('donations.portal_user_id, sum(donations.donation) as donation_sum')
//            ->groupBy('donations.portal_user_id');
    }

    public function donationsSum()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->selectRaw('donations.portal_user_id, sum(donations.donation) as donations_sum')
            ->groupBy('donations.portal_user_id');
    }

    public function firstDonation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'ASC');
    }

    public function last()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'DESC');
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
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->where('is_monthly_donation', '=', true)
            ->where('status', 'processed')
            ->where('created_at', '>=', $today->subDays($subDays)->toDateTimeString());
    }

    public function excludeFromCampaign()
    {
        return $this->hasOne('Modules\UserManagement\Entities\ExcludeUserFromCampaign', 'portal_user_id', 'id');
    }

    public function userPaymentOptions()
    {
        return $this->hasOne('Modules\UserManagement\Entities\UserPaymentOption', 'portal_user_id', 'id');
    }

    public function donorStatus()
    {
        return $this->hasOne('Modules\UserManagement\Entities\DonorStatus', 'portal_user_id', 'id');
    }
}
