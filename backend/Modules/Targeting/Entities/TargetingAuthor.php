<?php

namespace Modules\Targeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetingAuthor extends Model
{
    use SoftDeletes;
    protected $table = 'targeting_author';
    protected $fillable = ['targeting_id', 'author'];
}
