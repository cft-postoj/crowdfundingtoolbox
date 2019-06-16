<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class DonationInitialize extends Model
{
    protected $table = 'donation_initialize';
    protected $fillable = [
        //information from frontend
        'show_id',
        'email',
        'terms',
        'frequency',
        'donation_value'
        //TODO: add more fields for informations generated in backend (e.q. VS, link to payBySquare, etc.) and fill them
    ];

}
