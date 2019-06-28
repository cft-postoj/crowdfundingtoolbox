<?php

namespace Modules\Statistics\Services;


interface StatsDonorServiceInterface
{
    public function getDonors($from, $to, $monthly);
}