<?php

namespace Modules\Statistics\Services;


interface StatsDonationServiceInterface
{

    // get donations (one time and monthly) between dates $from and $to inclusive. $interval tells how donations should be
    // grouped (grouping by hours, days, weeks or months)
    public function getDonationsGroup($from, $to, $interval);

    // get donations (only monthly donations or one time donations, depending on $isMonthly) between dates $from and
    // $to inclusive. $interval tells how should be donations grouped (grouping by hours, days, weeks or months)
    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly);


    // get donors (one time and monthly) between dates $from and $to inclusive. $interval tells how donors should be
    // grouped (grouping by hours, days, weeks or months)
    public function getDonorsGroup($from, $to, $interval);

    // get donors (only monthly donations or one time donations, depending on $isMonthly) between dates $from and $to
    // inclusive. $interval tells how donors should be grouped (grouping by hours, days, weeks or months)
    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly);


    public function getDonorsAndDonationsTotal($from, $to);

    public function getDonorsAndDonationsTotalWithHistoric($from, $to);

}