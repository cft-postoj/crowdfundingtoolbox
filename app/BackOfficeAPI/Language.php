<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'languages';

    protected $fillable = [
        'slug', 'name'
    ];
}
