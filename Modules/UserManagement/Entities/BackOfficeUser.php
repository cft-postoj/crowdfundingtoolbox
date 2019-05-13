<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class BackOfficeUser extends Model
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'backoffice_users';

    protected $fillable = [
        'user_id', 'role_id'
    ];

}
