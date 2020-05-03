<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class PortalUserDonorCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'portal_user_id', 'donor_category_id', 'valid_from', 'valid_to', 'active', 'automatically_calculated',
        'manually_created', 'created_by'
    ];

    public function donorCategory()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\DonorCategory');
    }


}