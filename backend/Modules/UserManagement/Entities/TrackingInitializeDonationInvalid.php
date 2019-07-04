<?php

namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

class TrackingInitializeDonationInvalid extends Model
{
    protected $table = 'tracking_donation_initialize_invalid';
    protected $fillable = [
        //information from frontend
        'show_id',
        'email',
        'terms',
        'frequency',
        'donation_value'
    ];
}