<?php

namespace Modules\Campaigns\Entities;


class CampaignStatistics extends Model
{
    protected $table = 'campaigns';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'active', 'description', 'date_from', 'date_to', 'headline_text', 'updated_at'
    ];

}