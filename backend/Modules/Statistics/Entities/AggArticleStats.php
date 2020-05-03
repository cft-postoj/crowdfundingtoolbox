<?php

namespace Modules\Statistics\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AggArticleStats extends Model
{
    use SoftDeletes;
    protected $table = 'agg_article_stats';
    protected $fillable = ['article_id', 'title', 'url', 'visits', 'new_users', 'created_at', 'updated_at'];
}
