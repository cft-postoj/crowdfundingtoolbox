<?php

namespace Modules\Statistics\Repositories;

interface StatsDonationRepositoryInterface
{

    //get donations (only monthly donations or one time donations, depending on $isMonthly) between dates $from and
    // $to inclusive. $interval tells how should be donations grouped (grouping by hours, days, weeks or months)
    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly);

    // get donors (one time and monthly) between dates $from and $to inclusive. $interval tells how donors should be
    // grouped (grouping by hours, days, weeks or months)
    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly);

    //get sum of donors and donations specific between $from and $to
    public function getDonorsAndDonationsTotal($from, $to);

    //get sum of donors and donations specific between $from and $to grouped by monthly
    public function getDonorsAndDonationsTotalGroupMonthly($from, $to);

    //get all donations between date $from and $to grouped by monthly
    public function getDonations($from, $to, $monthly);


}