<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//store all widgets that user saw

class TrackingShow extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_show';
    protected $fillable = ['tracking_visit_id', 'widget_id'];

    public function visit()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\TrackingVisit', 'tracking_visit_id');
    }

    public function widget()
    {
        return $this->belongsTo('Modules\Campaigns\Entities\Widget', 'widget_id');
    }

    public function donation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'tracking_show_id', 'id');
    }

    public function donation()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation');
    }


}