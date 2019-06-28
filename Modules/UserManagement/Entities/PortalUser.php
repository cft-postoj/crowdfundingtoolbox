<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PortalUser extends Model
{
    use Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'portal_users';

    protected $fillable = [
        'user_id'
    ];


    public function gdpr()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\UserGdpr');
    }

    public function user()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\User');
    }


    public function visit()
    {
        return $this->hasMany('Modules\UserManagement\Entities\TrackingVisit');
    }

    public function donations()
    {
        return $this->hasMany('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'desc');
//            ->selectRaw('donations.portal_user_id, sum(donations.donation) as donation_sum')
//            ->groupBy('donations.portal_user_id');
    }

    public function donationsSum()
    {
        return $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->selectRaw('donations.portal_user_id, sum(donations.donation) as donations_sum')
            ->groupBy('donations.portal_user_id');
    }

    public function last()
    {
        $this->hasOne('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'DESC');
    }

    public function lastSql()
    {
        return $this->belongsTo('Modules\Payment\Entities\Donation', 'portal_user_id', 'id')
            ->orderBy('created_at', 'DESC')->toSql();
    }
}
