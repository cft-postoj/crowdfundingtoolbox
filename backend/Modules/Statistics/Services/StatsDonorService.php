<?php

namespace Modules\Statistics\Services;


use Illuminate\Support\Arr;
use Modules\Statistics\Repositories\StatsDonorRepository;

class StatsDonorService implements StatsDonorServiceInterface
{

    private $statsDonorRepository;

    public function __construct(StatsDonorRepository $statsDonorRepository)
    {
        $this->statsDonorRepository = $statsDonorRepository;
    }

    public function getDonors($from, $to, $monthly)
    {
       return $this->statsDonorRepository->getDonors($from, $to, $monthly);
    }


    public function countOfNewDonors($from, $to)
    {
        return  $this->statsDonorRepository->countOfNewDonors($from, $to);
    }


}