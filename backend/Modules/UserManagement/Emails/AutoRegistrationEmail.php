<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $username;
    private $emailToken;
    private $paymentMethod;
    private $variableSymbol;
    private $iban;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $emailToken, $paymentMethod, $variableSymbol, $iban)
    {
        $this->username = $username;
        $this->emailToken = $emailToken;
        $this->paymentMethod = $paymentMethod;
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
            ->from('smtp@crowdfundingtoolbox.news', env('MAIL_FROM_NAME'))
            ->view('emails.autoRegister', ['username' => $this->username,
                'emailToken' => $this->emailToken, 'paymentMethod' => $this->paymentMethod,
                'variableSymbol' => $this->variableSymbol, 'iban' => $this->iban]);
    }
}
