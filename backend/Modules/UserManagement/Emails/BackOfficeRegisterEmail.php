<?php


namespace Modules\UserManagement\Emails;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackOfficeRegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('CrowdfundingToolbox registration')
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->view('emails.backoffice.backofficeRegister');
    }
}