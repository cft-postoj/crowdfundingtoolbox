<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetVersion extends Model
{
    use SoftDeletes;
    protected $table = 'widget_versions';
    protected $fillable = [
        'widget_id', 'user_id', 'widget_data'
    ];
}
