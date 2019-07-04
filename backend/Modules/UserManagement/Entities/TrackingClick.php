<?php

namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

class TrackingClick extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_click';
    protected $fillable = ['show_id', 'node_class', 'node_id'];

    public function show()
    {
        return $this->hasOne('Modules\UserManagement\Entities\TrackingShow');
    }


}
