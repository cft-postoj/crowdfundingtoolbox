<?php

namespace Modules\Statistics\Services;


use Modules\Statistics\Repositories\StatsDonorRepository;

class StatsDonorService implements StatsDonorServiceInterface
{

    private $statsDonorRepository;

    public function __construct(StatsDonorRepository $statsDonorRepository)
    {
        $this->statsDonorRepository = $statsDonorRepository;
    }

    public function getDonors($from, $to, $monthly, $dataType)
    {
        if ($dataType == 'new') {
            return $this->getDonorsNew($from, $to, $monthly);
        }
        return $this->statsDonorRepository->getDonors($from, $to, $monthly);
    }

    private function getDonorsNew($from, $to, $monthly)
    {
        if ($monthly == null) {
            return $this->statsDonorRepository->getDonorsNew($from, $to, true)->merge(
                $this->statsDonorRepository->getDonorsNew($from, $to, false));
        }
        return $this->statsDonorRepository->getDonorsNew($from, $to, $monthly);
    }

    public function countOfNewDonors($from, $to)
    {
        return $this->statsDonorRepository->countOfNewDonors($from, $to);
    }

}