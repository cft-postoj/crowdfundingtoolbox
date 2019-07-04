<?php

namespace Modules\UserManagement\Entities;


use Illuminate\Database\Eloquent\Model;

// entity to track inserted emails.
// valid_email is false, when user tried to submit form with incorrect data (maybe someone from backoffice user could contact that user and help them - (eq. when user write something like foo@google.sk, etc.)
// valid_email is true when users input is valid email. Every valid email is sending to backend to gain more dat
//
class TrackingInsertEmail extends Model
{

    public $timestamps = true;

    protected $table = 'tracking_email';
    protected $fillable = ['show_id',
        //value from field, where user entered his email
        'email',
        //value to track/filter not valid emails
        'email_valid'
        ];

    public function show()
    {
        return $this->hasOne('Modules\UserManagement\Entities\TrackingShow');
    }

}
