<?php

namespace Modules\Targeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Targeting extends Model
{
    use SoftDeletes;
    protected $table = 'targeting';

    protected $fillable = ['campaign_id','signed','not_signed',
        'one_time','one_time_older_than', 'one_time_older_than_value', 'one_time_not_older_than','one_time_not_older_than_value', 'one_time_min', 'one_time_min_value', 'one_time_max','one_time_max_value',
        'monthly', 'monthly_older_than', 'monthly_older_than_value', 'monthly_not_older_than','monthly_not_older_than_value', 'monthly_min', 'monthly_min_value', 'monthly_max','monthly_max_value',
        'not_supporter',
        'read_articles_today','read_articles_today_min','read_articles_today_max',
        'read_articles_week','read_articles_week_min','read_articles_week_max',
        'read_articles_month','read_articles_month_min','read_articles_month_max',
        'registration_before', 'registration_before_value',
        'registration_after', 'registration_after_value',
        'url_specific'
    ];

    public function urls(){
        return $this->hasMany('\Modules\Targeting\Entities\TargetingUrl');
    }
}
