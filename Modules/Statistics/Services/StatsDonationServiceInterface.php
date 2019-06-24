<?php

namespace Modules\Statistics\Services;


interface StatsDonationServiceInterface
{

    public function getDonationsBetweenOverall($from, $to, $interval);

    public function getDonationsBetweenMonthly($from, $to, $interval, $isMonthly);

}