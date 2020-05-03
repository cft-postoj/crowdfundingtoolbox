<?php

namespace Modules\Targeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetingCategory extends Model
{
    use SoftDeletes;
    protected $table = 'targeting_category';
    protected $fillable = ['targeting_id', 'category', 'category_slug'];
}
