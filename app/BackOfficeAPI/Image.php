<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $table = 'images';
    protected $fillable = [
      'path', 'type', 'size'
    ];
}
