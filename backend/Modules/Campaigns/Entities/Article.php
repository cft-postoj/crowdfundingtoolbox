<?php

namespace Modules\Campaigns\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{

    use Filterable, SoftDeletes;
    protected $table = 'articles';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'article_id', 'author', 'title', 'thumbnail_url', 'url', 'description', 'category', 'category_url', 'article_created_at',
        'author_url', 'author_profile_image'
    ];


    //define class to filter
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\Campaigns\Entities\ArticleFilter::class);
    }

    public function visit()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\TrackingVisit');
    }

}
