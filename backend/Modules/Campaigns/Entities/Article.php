<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $table = 'articles';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'article_id', 'author', 'title', 'article_created_at'
    ];

    public function visit() {
        return $this->hasOne('\Modules\UserManagement\Entities\TrackingVisit');
    }

}
