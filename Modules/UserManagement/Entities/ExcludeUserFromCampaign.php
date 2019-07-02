<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ExcludeUserFromCampaign extends Model
{
    use SoftDeletes, Notifiable;
    protected $fillable = ['portal_user_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
