<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;

class WidgetCategory extends Model
{
    protected $table = 'widgets_category';
    protected $fillable = [
        'title', 'description', 'category_data'
    ];
}
