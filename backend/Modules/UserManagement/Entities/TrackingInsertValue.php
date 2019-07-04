<?php

namespace Modules\UserManagement\Entities;



use Illuminate\Database\Eloquent\Model;

class TrackingInsertValue extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_insert_value';
    protected $fillable = ['show_id', 'value', 'frequency'];

    public function show()
    {
        return $this->hasOne('Modules\UserManagement\Entities\TrackingShow');
    }


}
