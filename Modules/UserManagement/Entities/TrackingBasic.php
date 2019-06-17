<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

//basic values used for tracking user interaction with widgets

class TrackingBasic extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_basic';
    protected $fillable = [
        'user_id','user_cookie', 'url'
    ];

    public function show()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\TrackingShow');
    }
       

}