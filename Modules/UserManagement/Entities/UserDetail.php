<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
