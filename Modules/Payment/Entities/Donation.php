<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = [
        'user_id',
        'campaign_id',
        'widget_id',
        'referral_widget_id',
        'sum'
    ];
}
