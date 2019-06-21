<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id', 'first_name','last_name','address','zip','city','country','telephone'];
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo('\Modules\UserManagement\Entities\User', 'id', 'user_id');
    }
}
