<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['transaction_date'];

    protected $casts = [
        'amount' => 'float',
    ];

    public function donation()
    {
        return $this->belongsTo('\Modules\Payment\Entities\Donation', 'id', 'payment_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('\Modules\Payment\Entities\PaymentMethod', 'transfer_type');
    }

    public function donationMonthlyTrue()
    {
        return $this->belongsTo('\Modules\Payment\Entities\Donation', 'id', 'payment_id')
            ->where('is_monthly_donation', true);
    }

    public function donationMonthlyFalse()
    {
        return $this->belongsTo('\Modules\Payment\Entities\Donation', 'id', 'payment_id')
            ->where('is_monthly_donation', false);


    }
}
