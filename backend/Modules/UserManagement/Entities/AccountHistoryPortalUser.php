<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountHistoryPortalUser extends Model
{
    protected $table = 'account_history_portal_users';
    protected $fillable = ['portal_user_id', 'update_description', 'previous_data', 'updated_backoffice_user'];
}
