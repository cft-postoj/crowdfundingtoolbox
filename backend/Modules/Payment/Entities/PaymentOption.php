<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    protected $fillable = ['payment_method', 'payment_settings'];
}
