<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AggExportUser extends Model
{
    use SoftDeletes;
    protected $table = 'agg_export_users';
    protected $fillable = ['donor_id', 'email', 'first_name', 'last_name', 'street', 'city', 'zip', 'donor_type',
        'iban', 'variable_symbol', 'register_in', 'transfer_type', 'last_donation_date', 'declared_amount', 'recruited_date', 'monthly_donations'];
}
