<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGdpr extends Model
{
    protected $table = 'user_gdpr';
    protected $fillable = ['portal_user_id', 'agree_mail_sending', 'agree_general_conditions'];
    protected $hidden = ['created_at', 'id', 'updated_at', 'portal_user_id'];
}
