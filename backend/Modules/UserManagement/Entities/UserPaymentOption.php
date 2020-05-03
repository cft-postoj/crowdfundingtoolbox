<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserPaymentOption extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'user_payment_options';
    protected $fillable = ['portal_user_id', 'bank_account_number', 'payment_card', 'payment_card_expiration_date',
        'pairing_type', 'card_id', 'subscribe_at'];
}
