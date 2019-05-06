<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignImage extends Model
{
    use SoftDeletes;
    protected $table = 'campaign_images';
    protected $fillable = [
        'campaign_id', 'image_id', 'widget_id', 'device_type'
    ];
}
