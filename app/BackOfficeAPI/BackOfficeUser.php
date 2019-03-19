<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Passport\HasApiTokens;
//use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class BackOfficeUser extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'backoffice_users';

    protected $fillable = [
        'user_id', 'role_id'
    ];


}
