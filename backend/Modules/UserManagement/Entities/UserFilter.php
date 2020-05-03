<?php


namespace Modules\UserManagement\Entities;


use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{

    public $relations = [
        'userDetail'
    ];

    public function fullName($name)
    {
        return $this;

    }

}