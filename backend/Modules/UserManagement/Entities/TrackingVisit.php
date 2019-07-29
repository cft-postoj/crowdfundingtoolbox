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
        'portal_user_id','user_cookie', 'url', 'article_id'
    ];

    public function show()
    {
        return $this->hasMany('Modules\UserManagement\Entities\TrackingShow');
    }

    public function portalUser()
    {
        return $this->belongsTo('\Modules\UserManagement\Entities\PortalUser');
    }
    public function article()
    {
        return $this->belongsTo('\Modules\Campaigns\Entities\Article','article_id','article_id');
    }

}