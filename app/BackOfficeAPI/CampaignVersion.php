<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignVersion extends Model
{
    use SoftDeletes;
    protected $table = 'campaign_versions';

    protected $fillable = [
      'campaign_id', 'user_id', 'campaign_data'
    ];
}
