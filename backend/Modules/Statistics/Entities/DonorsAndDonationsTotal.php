<?php

namespace Modules\Statistics\Entities;


class DonorsAndDonationsTotal
{

    public $donors_count = 0;
    public $donations_sum = 0;
    public $donations_avg = 0;
    public $is_monthly_donation = 0;
    public $donors_new = 0;

    /**
     * DonorsAndDonationsTotal constructor.
     */
    public function __construct($monthly)
    {
        $this->is_monthly_donation = $monthly;
    }
}