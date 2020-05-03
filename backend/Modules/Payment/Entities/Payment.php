<?php

namespace Modules\Payment\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    use Filterable;
    protected $table = 'payments';
    protected $fillable = ['transaction_id', 'iban', 'amount', 'created_by', 'transfer_type', 'variable_symbol',
        'transaction_date', 'payment_notes', 'payer_reference', 'specific_symbol', 'constant_symbol', 'uuid', 'account_name'];

    protected $casts = [
        'amount' => 'float',
    ];

    //define class to filter
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\Payment\Entities\PaymentFilter::class);
    }


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
