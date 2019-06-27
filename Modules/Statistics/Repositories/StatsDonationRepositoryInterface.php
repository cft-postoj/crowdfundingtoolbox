<?php

namespace Modules\Statistics\Repositories;

interface StatsDonationRepositoryInterface
{

    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly);

    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly);

    public function getDonorsAndDonationsTotal($from, $to);

}