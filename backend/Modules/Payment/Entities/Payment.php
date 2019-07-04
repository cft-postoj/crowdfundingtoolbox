<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // model which track all created payment.. then foreign key (from donations table to payments table)
    protected $fillable = [];
}
