<?php

namespace Modules\UserManagement\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $amount, $variableSymbol, $cardNumber, $emailType, $period, $paymentTypeId, $token, $portal_user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount, $variableSymbol, $cardNumber, $emailType, $period, $paymentTypeId, $generatedToken, $portal_user_id)
    {
        $this->amount = $amount;
        $this->variableSymbol = $variableSymbol;
        $this->cardNumber = $cardNumber;
        $this->emailType = $emailType;
        $this->period = $period;
        $this->paymentTypeId = $paymentTypeId;
        $this->token = $generatedToken;
        $this->portal_user_id = $portal_user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->period === 'monthly' && $this->paymentTypeId === 2 && $this->emailType === 'donation') {
            $subject = __('cft-emails.donation.monthly.comfortpay.subject');
        } else if ($this->period === 'monthly' && $this->paymentTypeId === 1 && $this->emailType === 'donation') {
            $subject = __('cft-emails.donation.monthly.bankTransfer.subject');
        } else if ($this->period === 'monthly' && $this->emailType === 'bankTransferSuccessFirstTime') {
            $subject = __('cft-emails.donation.monthly.bankTransferFirstTime.subject');
        } else if ($this->period === 'oneTime' && $this->paymentTypeId === 1 && $this->emailType === 'donation') {
            $subject = __('cft-emails.donation.oneTime.bankTransfer.moreThan99.subject');
        } else if ($this->period === 'oneTime' && $this->paymentTypeId === 2 && $this->emailType === 'donation') {
            $subject = __('cft-emails.donation.oneTime.cardpay.moreThan99.subject');
        } else if ($this->period === 'oneTime' && $this->paymentTypeId === 3 && $this->emailType === 'donation') {
            $subject = __('cft-emails.donation.oneTime.payBySquare.moreThan99.subject');
        } else if ($this->period === 'oneTime' && $this->paymentTypeId === 2 && $this->emailType === 'donationNotSuccess') {
            $subject = __('cft-emails.donation.oneTime.cardpay.notSuccessCardpayPayment.subject');
        } else if ($this->period === 'monthly' && $this->paymentTypeId === 2 && $this->emailType === 'donationNotSuccess') {
            $subject = __('cft-emails.donation.monthly.account.notSuccessComfortpayPayment.subject');
        } else {
            $subject = __('cft-emails.donation.monthly.bankTransfer.subject');
        }

        return $this->subject($subject)
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('emails.successfulDonation');
    }
}
