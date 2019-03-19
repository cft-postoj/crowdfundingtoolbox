<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use SoftDeletes;
    protected $table = 'widgets';
    protected $fillable = [
        'widget_type_id', 'campaign_id', 'active', 'use_campaign_settings'
    ];
}
