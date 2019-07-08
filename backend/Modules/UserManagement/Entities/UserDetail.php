<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'street', 'house_number', 'telephone_prefix', 'zip', 'city', 'country', 'telephone', 'delivery_address_is_same'];
    protected $hidden = ['user_id', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('\Modules\UserManagement\Entities\User', 'id', 'user_id');
    }
}
