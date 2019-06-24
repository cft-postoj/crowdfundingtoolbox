<?php

namespace Modules\Statistics\Services;

use Modules\Statistics\Repositories\StatsDonationRepository;
use stdClass;

class StatsDonationService implements StatsDonationServiceInterface
{
    private $statsDonationRepository;

    public function __construct(StatsDonationRepository $statsDonationRepository)
    {
        $this->statsDonationRepository = $statsDonationRepository;
    }

    public function getDonationsBetweenOverall($from, $to, $interval)
    {
        $result = new stdClass;
        //monthly:
        $result->monthly = $this->getDonationsBetweenMonthly($from, $to, $interval, true);
        //one time payments
        $result->oneTime = $this->getDonationsBetweenMonthly($from, $to, $interval, false);
        return $result;
    }

    public function getDonationsBetweenMonthly($from, $to, $interval, $isMonthly)
    {
        return $this->statsDonationRepository->getDonationsBetweenMonthly($from, $to, $interval, $isMonthly);
    }

}