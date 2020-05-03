<?php

namespace Modules\Targeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetingExcludedUrl extends Model
{
    use SoftDeletes;
    protected $table = 'targeting_excluded_url';
    protected $fillable = ['targeting_id', 'path'];
}
