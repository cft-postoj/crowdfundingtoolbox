<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['transaction_id', 'iban', 'amount', 'created_by', 'transfer_type', 'variable_symbol',
        'transaction_date', 'payment_notes', 'payer_reference'];

    public function donation()
    {
        return $this->belongsTo('\Modules\Payment\Entities\Donation', 'id', 'payment_id');
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
