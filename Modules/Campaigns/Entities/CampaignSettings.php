<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignSettings extends Model
{
    use SoftDeletes;
    protected $table = 'campaign_settings';
    protected $fillable = [
        'campaign_id',
        'payment_type',
        'payment_settings',
        'promote_settings',
        'widget_settings'
    ];
}
