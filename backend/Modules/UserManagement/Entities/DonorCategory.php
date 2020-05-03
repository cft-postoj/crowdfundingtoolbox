<?php


namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonorCategory extends Model
{
    use SoftDeletes;

    /**
     *
     *
     * @var min_value - minimum value to be assigned to this category, inclusive, nullable
     */
    protected $fillable = [
        'name', 'min_value'
    ];
}