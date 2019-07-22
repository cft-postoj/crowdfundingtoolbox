<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetType extends Model
{
    use SoftDeletes;
    protected $table = 'widget_types';
}
