<?php


namespace Modules\Statistics\Entities;


class DonorsAndDonationsTotalWrapper
{
    public $monthly;
    public $one_time;
    public $total;

    /**
     * DonorsAndDonationsTotal constructor.
     */
    public function __construct()
    {
        $this->one_time = new DonorsAndDonationsTotal(false);
        $this->monthly = new DonorsAndDonationsTotal(true);
        $this->total = new DonorsAndDonationsTotal(null);
    }
}