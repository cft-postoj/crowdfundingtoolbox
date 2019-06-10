<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['first_name','last_name','address','zip','city','country','telephone'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
