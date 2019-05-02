<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetResult extends Model
{
    use SoftDeletes;
    protected $table = 'widget_results';
    protected $fillable = [
        'widget_id', 'campaign_id', 'widget_type_id', 'desktop', 'tablet', 'mobile'
    ];
}
