<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//auto registration email during donation. Contains infromation about payment and information about new account
class AutoRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $username;
    private $emailToken;
    private $variableSymbol;
    private $iban;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $emailToken, $variableSymbol, $iban)
    {
        $this->username = $username;
        $this->emailToken = $emailToken;
        $this->variableSymbol = $variableSymbol;
        $this->iban = $iban;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('cft-emails.donationInitialize.title'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->view('emails.autoRegister', ['username' => $this->username,
                'token' => $this->emailToken,
                'variableSymbol' => $this->variableSymbol, 'iban' => $this->iban]);
    }
}
