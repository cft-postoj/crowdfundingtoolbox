<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignsConfiguration extends Model
{
    use SoftDeletes;
    protected $table = 'campaigns_configuration';
    protected $hidden = array('id', 'deleted_at', 'created_at', 'updated_at');
}
