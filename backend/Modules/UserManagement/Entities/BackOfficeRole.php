<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class BackOfficeRole extends Model
{
    protected $table = 'backoffice_roles';
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
