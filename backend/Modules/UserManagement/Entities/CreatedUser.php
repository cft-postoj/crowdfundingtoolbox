<?php


namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Class to represent new created users, who did not go through 3 step of donation
// Send them email with registration after 15 minutes, when they don't go to 3 step.
// If user go on 3.step, than soft delete and don't send him registration email
// Email should be sent using cron job, when send_mail_at is smaller than current date
class CreatedUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'portal_user_id', 'tracking_show_id', 'send_mail_at', 'email_was_sent_at'
    ];

    public function trackingShow()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\TrackingShow');
    }

    public function portalUser()
    {
        return $this->belongsTo('Modules\UserManagement\Entities\PortalUser');
    }



}