<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $portal_user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $portal_user_id)
    {
        $this->token = $token;
        $this->portal_user_id = $portal_user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('cft-emails.register.subject'))
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('emails.register');
    }
}
