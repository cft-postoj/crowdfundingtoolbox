<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PortalUser extends Model
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'portal_users';

    protected $fillable = [
        'user_id'
    ];

    public function targeting() {

    }
}
