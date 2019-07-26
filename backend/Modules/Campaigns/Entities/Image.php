<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Image extends Model
{
    use SoftDeletes;
    protected $table = 'images';
    protected $fillable = [
        'path', 'type', 'size'
    ];

    protected $appends = ['url'];

    /**
     * Transform path (where is only name of image) into absolute url of image
     *
     * @return string
     */
    public function getUrlAttribute()
    {
            $appUrl = env('APP_URL');
            if (env('APP_ENV') === 'prod') {
                $appUrl = env('CFT_PORTAL_PROD_URL');
            }
        return $appUrl.env('STORAGE_PREFIX').$this->attributes['path'];
    }


}
