<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class DonorStatus extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['portal_user_id', 'monthly_donor'];
    protected $table = 'donor_statuses';

}
