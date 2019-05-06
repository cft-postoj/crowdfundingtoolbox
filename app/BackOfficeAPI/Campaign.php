<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;
    protected $table = 'campaigns';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'active', 'description', 'date_from', 'date_to', 'headline_text', 'updated_at'
    ];
}
