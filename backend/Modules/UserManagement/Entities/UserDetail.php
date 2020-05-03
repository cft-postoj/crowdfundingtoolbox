<?php

namespace Modules\UserManagement\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\Services\UserSearchService;

class UserDetail extends Model
{
    use Filterable;
    protected $fillable = ['user_id', 'first_name', 'last_name', 'street', 'house_number', 'telephone_prefix', 'zip', 'city', 'country', 'telephone', 'delivery_address_is_same'];
    protected $hidden = ['user_id', 'updated_at', 'deleted_at'];

    protected $appends = ['searchName'];

    //define class to filter
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\UserManagement\Entities\UserDetailFilter::class);
    }

    public function user()
    {
        return $this->belongsTo('\Modules\UserManagement\Entities\User', 'id', 'user_id');
    }

    public function getSearchNameAttribute() {
        $firstName = $this->attributes['first_name'];
        $lastName = $this->attributes['last_name'];
        $userD = new UserSearchService();
        $searchName = strtolower($userD->removeAscents($firstName) . ' ' . $userD->removeAscents($lastName));
        return $searchName;
    }
}
