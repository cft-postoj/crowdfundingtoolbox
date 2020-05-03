<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignsVisited extends Model
{
    use SoftDeletes;
    protected $table = 'campaigns_visited';
    // column visits represents count of show targeted url
    protected $fillable = ['campaign_id', 'portal_user_id', 'user_cookie', 'visits', 'click_on_x'];
    protected $dates = ['deleted_at'];
}
