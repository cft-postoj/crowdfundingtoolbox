<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = [
        'donation',
        'is_monthly_donation'
    ];
    protected $casts = [
        'donation' => 'float',
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

}
