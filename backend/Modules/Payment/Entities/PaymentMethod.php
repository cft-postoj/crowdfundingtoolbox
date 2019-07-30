<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [];

    public function paymentOption() {
        return $this->hasOne('\Modules\Payment\Entities\PaymentOption', 'payment_method', 'id');
    }
}
