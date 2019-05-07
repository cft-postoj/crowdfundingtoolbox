<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdfundingSettings extends Model
{
    use SoftDeletes;
    protected $table = 'crowdfunding_settings';
}
