<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $emailToken)
    {
        $this->username = $username;
        $this->emailToken = $emailToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank you for your support')
            ->from('smtp@crowdfundingtoolbox.news')
            ->view('emails.autoRegister');
    }
}
