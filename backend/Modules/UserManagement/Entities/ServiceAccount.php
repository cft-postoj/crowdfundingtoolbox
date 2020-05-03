<?php


namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

class ServiceAccount extends Model
{
    protected $table = 'service_accounts';
    protected $fillable= ['user_id'];

    public function user()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\User');
    }

}