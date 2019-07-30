<?php

namespace Modules\Statistics\Services;


use Carbon\Carbon;
use Modules\Statistics\Repositories\StatsDonorRepository;
use Modules\UserManagement\Services\UserSearchService;
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

            $notModifiedResults = $this->getDonorsNew($from, $to, $monthly);
            //map campaign's name from firstDonation into new field 'campaign_name' to achieve same data structure of returned object
            $result->donors = collect($notModifiedResults)->map(function ($notModifiedResult) {
                $notModifiedResult['campaign_name'] = $notModifiedResult['firstDonation']['widget']['campaign']['name'];
                return $notModifiedResult;
            });
        }
        if ($dataType == 'stoppedSupporting') {
            $result = $this->getDonorsStoppedSupporting($to, $limit);
        }
        if ($dataType == 'didNotPay') {
            $result = $this->didNotPay($from, $to, $limit);
        }
        if ($dataType == 'onlyInitializeDonation') {
            $result = $this->onlyInitializeDonation($from, $to, $limit);
        }
        if ($dataType == null) {
            $notModifiedResults = $this->statsDonorRepository->getDonors($from, $to, $monthly);
            //map campaign's name from firstDonation into new field 'campaign_name' to achieve same data structure of returned object
            $result->donors = collect($notModifiedResults)->map(function ($notModifiedResult) {
                $notModifiedResult['campaign_name'] = $notModifiedResult['firstDonation']['widget']['campaign']['name'];
                return $notModifiedResult;
            });
        }
        if ($dataType == 'allPortalUsers') {
            $result->donors = $this->getAllPortalUsers($from, $to);
        }
        return $result;
    }

    private function getAllPortalUsers($from, $to)
    {
        return $this->statsDonorRepository->getAllPortalUsers($from, $to);
    }

    public function getDonorsNew($from, $to, $monthly)
    {
        if ($monthly == null) {
            return $this->statsDonorRepository->getDonorsNew($from, $to, true)->merge(
                $this->statsDonorRepository->getDonorsNew($from, $to, false));
        }
        return $this->statsDonorRepository->getDonorsNew($from, $to, $monthly);
    }


    public function getDonorsStoppedSupporting($to, $limit)
    {
        // $stopAfterDays -> number of days, used as input for $stopAfterDate
        $stopAfterDays = 60;
        // after this date, every users, who dont have payment in dates between  $to and $carbonDateStopped is marked
        // as user, who stopped to donate and therefore should be returned in method getDonorsStoppedSupporting
        $stopAfterDate = Carbon::createFromDate($to)->subDays($stopAfterDays);
        $result = new stdClass;

        $notModifiedResults = $this->statsDonorRepository->getDonorsStoppedSupporting($stopAfterDate, $limit);
        //map campaign's name from firstDonation into new field 'campaign_name' to achieve same data structure of returned object
        $result->donors = collect($notModifiedResults)->map(function ($notModifiedResult) {
            $notModifiedResult['campaign_name'] = $notModifiedResult['firstDonation']['widget']['campaign']['name'];
            return $notModifiedResult;
        });
        $result->count = $this->getDonorsStoppedSupportingCount($stopAfterDate);
        return $result;
    }

    public function countOfNewDonors($from, $to)
    {
        return $this->statsDonorRepository->countOfNewDonors($from, $to);
    }

    public function didNotPay($from, $to, $limit)
    {
        $result = new stdClass;

        $notModifiedResults = $this->statsDonorRepository->didNotPay($from, $to, $limit);
        //map campaign's name from firstDonation into new field 'campaign_name' to achieve same data structure of returned object
        $result->donors = collect($notModifiedResults)->map(function ($notModifiedResult) {
            $notModifiedResult['campaign_name'] = $notModifiedResult['firstDonation']['widget']['campaign']['name'];
            return $notModifiedResult;
        });
        $result->count = $this->didNotPayCount($from, $to);
        return $result;
    }

    public function onlyInitializeDonation($from, $to, $limit = null)
    {
        $result = new stdClass;
        $notModifiedResults = $this->statsDonorRepository->onlyInitializeDonation($from, $to, $limit);
        $result->donors = $notModifiedResults;
        if ($limit !== null) {
            $result->count = count($this->statsDonorRepository->onlyInitializeDonation($from, $to));
        } else {
            $result->count = count($notModifiedResults);
        }
        return $result;
    }

    public function getDonorsStoppedSupportingCount($stopAfterDate)
    {
        return $this->statsDonorRepository->getDonorsStoppedSupportingCount($stopAfterDate);
    }

    public function didNotPayCount($from, $to)
    {
        return $this->statsDonorRepository->didNotPayCount($from, $to);
    }
}