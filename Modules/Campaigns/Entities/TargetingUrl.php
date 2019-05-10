<?php

namespace Modules\Campaigns\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetingUrl extends Model
{
    use SoftDeletes;
    protected $table = 'targeting_url';

    protected $fillable = [
        'targeting_id', 'path'
    ];

    public function targeting()
    {
        return $this->belongsTo('App\BackOfficeAPI\Targeting');
    }
}
