<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

//basic values used for tracking user interaction with widgets
//create new row in table for every new loaded page
class TrackingVisit extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_visit';
    protected $fillable = [
        'user_id','user_cookie', 'url', 'article_id', 'title'
    ];

    public function show()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\TrackingShow');
    }
       

}