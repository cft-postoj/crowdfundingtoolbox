<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;

class WidgetCategory extends Model
{
    protected $table = 'widgets_category';
    protected $fillable = [
        'title', 'description', 'category_data'
    ];
}
