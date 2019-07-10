<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = [
        'amount',
        'is_monthly_donation',
        'payment_method',
        'status',
        'tracking_show_id'
    ];
    protected $casts = [
        'amount' => 'float',
    ];

    public function portalUser()
    {
        return $this->belongsTo('\Modules\UserManagement\Entities\PortalUser');
    }

    public function widget()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Widget');
    }

    public function widgetReferral()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Widget', 'id', 'referral_widget_id');
    }

    public function payment()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Widget', 'id', 'referral_widget_id');
    }

    public function payments()
    {
        return $this->hasOne('\Modules\Payment\Entities\Payment', 'id', 'payment_id');
    }

    public function trackingShow()
        {
        return $this->belongsTo('\Modules\UserManagement\Entities\TrackingShow','tracking_show_id');
    }

}
