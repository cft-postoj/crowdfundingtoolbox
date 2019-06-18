<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class GeneratedUserToken extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['user_id', 'generated_token'];
    protected $table = 'generated_user_token';

}
