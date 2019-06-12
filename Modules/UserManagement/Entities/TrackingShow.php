<?php
namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//basic values used for tracking user interaction with widgets

class TrackingShow extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_show';
    protected $fillable = ['basic_id', 'widget_id', 'article_id', 'title'];

    public function basic()
    {
        return $this->hasOne('Modules\UserManagement\Entities\TrackingBasic');
    }


}