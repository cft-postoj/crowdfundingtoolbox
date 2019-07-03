<?php

namespace Modules\Statistics\Services;

use Carbon\Carbon;
use Modules\Statistics\Entities\DonorsAndDonationsTotal;
use Modules\Statistics\Entities\DonorsAndDonationsTotalWrapper;
use Modules\Statistics\Repositories\StatsDonationRepository;
use stdClass;

class StatsDonationService implements StatsDonationServiceInterface
{
    private $statsDonationRepository;
    private $statsDonorService;

    public function __construct(StatsDonationRepository $statsDonationRepository, StatsDonorService $statsDonorService)
    {
        $this->statsDonationRepository = $statsDonationRepository;
        $this->statsDonorService = $statsDonorService;
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
        $result = new DonorsAndDonationsTotalWrapper();

        // handle monthly group from repository

        $monthlyGroup = $this->getDonorsAndDonationsTotalGroupMonthly($from, $to);
        if (empty($this->getByValue($monthlyGroup, 'is_monthly_donation', true))) {
            // create empty object called monthly inside result to preserve structure of result (using group by in db layer
            // can return empty array if there is no result to match where clauses)
            $result->monthly = new DonorsAndDonationsTotal(true);
        } else {
            // fill monthly with returned data, find only object, where is_monthly_donation is true
            $result->monthly = $this->getByValue($monthlyGroup, 'is_monthly_donation', true);
        }

        if (empty($this->getByValue($monthlyGroup, 'is_monthly_donation', false))) {
            $result->one_time = new DonorsAndDonationsTotal(false);
        } else {
            // fill monthly with returned data, find only object, where is_monthly_donation is false
            $result->one_time = $this->getByValue($monthlyGroup, 'is_monthly_donation', false);
        }

        // add new donors in result
        $newUsersCount = $this->statsDonorService->countOfNewDonors($from, $to);
        $result->monthly->donors_new = $this->getCount($newUsersCount, true);
        $result->one_time->donors_new = $this->getCount($newUsersCount, false);

        //add total
        $result->total = $this->statsDonationRepository->getDonorsAndDonationsTotal($from, $to);
        $result->total->donors_new = $result->monthly->donors_new +  $result->one_time->donors_new;

        return $result;
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

    public function getDonations($from, $to, $monthly)
    {
        return $this->statsDonationRepository->getDonations($from, $to, $monthly);
    }

    private function getDonorsAndDonationsTotalGroupMonthly($from, $to)
    {
        return $this->statsDonationRepository->getDonorsAndDonationsTotalGroupMonthly($from, $to);
    }

    //safe function to get field count from object. If object is null, return 0
    private function getCount($newUsersCount, $monthly)
    {
        $newUsersObject = $this->getByValue($newUsersCount, 'is_monthly_donation', $monthly);
        return $newUsersObject == null ? 0 : $newUsersObject->count;
    }

    //filter array by key value pair
    private function getByValue($array, string $key, $value)
    {
        if ($array === null) {
            return null;
        }
        foreach ($array as $object) {
            if ($object[$key] === $value) {
                return $object;
            }
        }
    }

}