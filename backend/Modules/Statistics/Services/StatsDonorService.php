<?php

namespace Modules\Statistics\Services;


use Carbon\Carbon;
use Modules\Statistics\Repositories\StatsDonorRepository;
use stdClass;

class StatsDonorService implements StatsDonorServiceInterface
{

    private $statsDonorRepository;

    public function __construct(StatsDonorRepository $statsDonorRepository)
    {
        $this->statsDonorRepository = $statsDonorRepository;
    }

    public function getDonors($from, $to, $monthly, $dataType, $limit)
    {
        $result = new stdClass;
        if ($dataType == 'new') {
            $result->donors = $this->getDonorsNew($from, $to, $monthly);
        }
        if ($dataType == 'stoppedSupporting') {
            $result = $this->stoppedSupporting($to, $limit);
        }
        if ($dataType == 'didNotPay') {
            $result = $this->didNotPay($from, $to, $limit);
        }
        if ($dataType == null) {
            $result->donors = $this->statsDonorRepository->getDonors($from, $to, $monthly);
        }
        return $result;
    }

    private function getDonorsNew($from, $to, $monthly)
    {
        if ($monthly == null) {
            return $this->statsDonorRepository->getDonorsNew($from, $to, true)->merge(
                $this->statsDonorRepository->getDonorsNew($from, $to, false));
        }
        return $this->statsDonorRepository->getDonorsNew($from, $to, $monthly);
    }


    private function stoppedSupporting($to, $limit)
    {
        // $stopAfterDays -> number of days, used as input for $stopAfterDate
        $stopAfterDays = 60;
        // after this date, every users, who dont have payment in dates between  $to and $carbonDateStopped is marked
        // as user, who stopped to donate and therefore should be returned in method getDonorsStoppedSupporting
        $stopAfterDate = Carbon::createFromDate($to)->subDays($stopAfterDays);
        $result = new stdClass;
        $result->donors = $this->statsDonorRepository->getDonorsStoppedSupporting($stopAfterDate, $limit);
        $result->count = $this->statsDonorRepository->getDonorsStoppedSupportingCount($stopAfterDate);
        return $result;
    }

    public function countOfNewDonors($from, $to)
    {
        return $this->statsDonorRepository->countOfNewDonors($from, $to);
    }

    private function didNotPay($from, $to, $limit)
    {
        $result = new stdClass;
        $result->donors = $this->statsDonorRepository->didNotPay($from, $to, $limit);
        $result->count = $this->statsDonorRepository->didNotPayCount($from, $to);
        return $result;
    }

}