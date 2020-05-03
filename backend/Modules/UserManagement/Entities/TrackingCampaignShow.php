<?php


namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

class TrackingCampaignShow extends Model
{
    public $timestamps = true;

    protected $table = 'tracking_campaign_show';

    protected $fillable = ['portal_user_id', 'user_cookie_id', 'campaign_id', 'valid_until'];

}