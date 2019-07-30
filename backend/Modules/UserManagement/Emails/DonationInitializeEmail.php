<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationInitializeEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $username;
    private $variableSymbol;
    private $iban;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $variableSymbol, $iban)
    {
        $this->username = $username;
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
        return $this->subject('Thank you for your support')
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->view('emails.donationInitialize', ['username' => $this->username,
                'variableSymbol' => $this->variableSymbol, 'iban' => $this->iban]);
    }
}