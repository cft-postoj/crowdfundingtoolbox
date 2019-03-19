<?php

namespace App\BackOfficeAPI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetSettings extends Model
{
    use SoftDeletes;
    protected $table = 'widget_settings';
    protected $fillable = [
      'widget_id', 'desktop', 'tablet', 'mobile'
    ];
}
