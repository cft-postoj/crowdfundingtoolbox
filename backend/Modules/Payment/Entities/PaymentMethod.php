<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;
    protected $table = 'payment_methods';
    protected $fillable = [];

    public function paymentOption() {
        return $this->hasOne('\Modules\Payment\Entities\PaymentOption', 'payment_method', 'id');
    }
}
