<?php

namespace Modules\Statistics\Services;

use Carbon\Carbon;
use Modules\Statistics\Repositories\StatsDonationRepository;
use stdClass;

class StatsDonationService implements StatsDonationServiceInterface
{
    private $statsDonationRepository;

    public function __construct(StatsDonationRepository $statsDonationRepository)
    {
        $this->statsDonationRepository = $statsDonationRepository;
    }

    public function getDonationsGroup($from, $to, $interval)
    {
        $result = new stdClass;
        //monthly:
        $result->monthly = $this->getDonationsGroupIsMonthly($from, $to, $interval, true);
        //one time payments
        $result->oneTime = $this->getDonationsGroupIsMonthly($from, $to, $interval, false);
        return $result;
    }

    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        return $this->statsDonationRepository->getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly);
    }


    public function getDonorsGroup($from, $to, $interval)
    {
        $result = new stdClass;
        //monthly:
        $result->monthly = $this->getDonorsGroupIsMonthly($from, $to, $interval, true);
        //one time payments
        $result->oneTime = $this->getDonorsGroupIsMonthly($from, $to, $interval, false);
        return $result;
    }

    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        return $this->statsDonationRepository->getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly);
    }

    public function getDonorsAndDonationsTotal($from, $to)
    {
        return $this->statsDonationRepository->getDonorsAndDonationsTotal($from, $to);
    }

    public function getDonorsAndDonationsTotalWithHistoric($from, $to)
    {
        $daysBetween = Carbon::create($from)->diffInDays(Carbon::create($to));
        $historicFrom = Carbon::create($from)->subDays($daysBetween)->subDays(1);
        $historicTo = Carbon::create($from)->subDays(1);

        $actual = $this->getDonorsAndDonationsTotal($from, $to);
        $historic = $this->getDonorsAndDonationsTotal($historicFrom, $historicTo);

        $result = new stdClass;
        $result->current = $actual;
        $result->previous = $historic;

        return $result;
    }

}