<?php

namespace Modules\Targeting\Entities;

use Illuminate\Database\Eloquent\Model;

class AggregateTargeting extends Model
{
    protected $table = 'agg_targeting';
    protected $fillable = ['portal_user_id', 'user_id', 'email', 'name', 'has_valid_address',
        'is_supporter', 'last_donation_before', 'last_donation_value', 'last_donation_id', 'monthly_supporter',
        'all_donations', 'read_articles_today', 'read_articles_week', 'read_articles_month', 'unlocked_at'];
}
