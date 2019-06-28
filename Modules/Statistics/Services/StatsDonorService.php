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

    public function sortFunction($a, $b)
    {
        return $a['last_donation']['created_at'] - $b['last_donation']['created_at'];
    }

    public function getDonors($from, $to, $monthly)
    {
       return $this->statsDonorRepository->getDonors($from, $to, $monthly);
    }


}