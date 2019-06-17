<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;

class CampaignPromote extends Model
{
    protected $table = 'campaign_promotes';
    protected $fillable = ['campaign_id', 'start_date_value', 'is_end_date', 'end_date_value', 'donation_goal_value'];

    public function campaign() {
        return $this->belongsTo('\Modules\Campaigns\Entities\Campaign');
    }

}
