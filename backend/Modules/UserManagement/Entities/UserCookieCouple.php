<?php

namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

// to track users cookie and user_id
// created after direct registration, after registration during donation and after login
class UserCookieCouple extends Model
{
    protected $table = 'user_cookie_couple';

    protected $fillable = [
        'portal_user_id',
        'user_cookie_id'
    ];

    public function user() {

    }

    public function cookie() {

    }


}