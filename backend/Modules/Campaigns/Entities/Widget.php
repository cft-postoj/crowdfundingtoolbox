<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use SoftDeletes;
    protected $table = 'widgets';
    protected $fillable = [
        'widget_type_id', 'campaign_id', 'active', 'use_campaign_settings'
    ];

    public function widgetSettings()
    {
        return $this->hasOne('\Modules\Campaigns\Entities\WidgetSettings');
    }

    public function campaignImage()
    {
        return $this->hasMany('\Modules\Campaigns\Entities\CampaignImage');
    }

    public function campaign()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Campaign');
    }

    public function widgetType()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\WidgetType');
    }

    public function show()
    {
        return $this->hasMany('\Modules\UserManagement\Entities\TrackingShow');
    }

    public function donation()
    {
        return $this->hasMany('\Modules\Payment\Entities\Donation');
    }

}
