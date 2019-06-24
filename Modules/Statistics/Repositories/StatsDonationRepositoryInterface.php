<?php

namespace Modules\Statistics\Repositories;

interface StatsDonationRepositoryInterface
{

    public function getDonationsBetweenMonthly($from, $to, $interval, $isMonthly);

}