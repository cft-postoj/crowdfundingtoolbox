<?php

namespace Modules\Translations\Entities;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';

    protected $fillable = [
        'language_id', 'trans_id', 'trans_string'
    ];
}
