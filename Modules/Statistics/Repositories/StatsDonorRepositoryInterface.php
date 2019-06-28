<?php

namespace Modules\Statistics\Repositories;


interface StatsDonorRepositoryInterface
{
    public function getDonors($from, $to, $monthly);


}