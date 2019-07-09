<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [];

    public function pairedDonation()
    {
        return $this->belongsTo('\Modules\Payment\Entities\Donation', 'id', 'payment_id');
    }
}
