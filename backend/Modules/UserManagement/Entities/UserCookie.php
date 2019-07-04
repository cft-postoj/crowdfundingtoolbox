<?php

namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

class UserCookie extends Model
{
    public $timestamps = true;

    protected $table = 'user_cookie';
    protected $fillable = ['device_type', 'browser', 'platform', 'ip', 'ip_forwarded'];

}