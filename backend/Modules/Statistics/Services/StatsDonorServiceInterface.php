<?php

namespace Modules\Statistics\Services;


interface StatsDonorServiceInterface
{
    public function getDonors($from, $to, $monthly, $dataType);

    public function countOfNewDonors($from, $to);
}