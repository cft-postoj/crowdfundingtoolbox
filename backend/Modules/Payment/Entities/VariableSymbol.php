<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class VariableSymbol extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'variable_symbol', 'portal_user_id'
    ];
    protected $table = 'variable_symbols';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
