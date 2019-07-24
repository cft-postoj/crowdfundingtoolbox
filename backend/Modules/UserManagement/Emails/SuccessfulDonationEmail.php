<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessfulDonationEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $username;
    private $emailToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('We got payment. Thank you!')
            ->from('smtp@crowdfundingtoolbox.news', env('MAIL_FROM_NAME'))
            ->view('emails.successfulDonation', ['username' => $this->username]);
    }
}
