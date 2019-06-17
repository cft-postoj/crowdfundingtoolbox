<?php
namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//store all widgets that user saw

class TrackingShow extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_show';
    protected $fillable = ['visit_id', 'widget_id'];

    public function visit()
    {
        return $this->hasOne('Modules\UserManagement\Entities\TrackingVisit');
    }


}