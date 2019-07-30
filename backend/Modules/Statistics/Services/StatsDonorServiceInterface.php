<?php

namespace Modules\Statistics\Services;


interface StatsDonorServiceInterface
{
    //get all donors in time interval, optional $monthly property to get only monthly donors or only one time donors
    public function getDonors($from, $to, $monthly, $dataType, $limit);

    //get count of new donors in time interval
    public function countOfNewDonors($from, $to);

    //get only new donors in time interval, optional $monthly property to get only monthly donors or only one time donors
    public function getDonorsNew($from, $to, $monthly);

    //get users who stopped supporting, $limit to get only specific number of results
    public function getDonorsStoppedSupporting($stopAfterDate, $limit);

    //count of users who stopped supporting
    public function getDonorsStoppedSupportingCount($stopAfterDate);

    //get users who should pay but no payment was assigned with their donation yet and there is no another assigned
    // payment after that last promised donation
    public function didNotPay($from, $to, $limit);

    //number of users who promised to pay but donation isn't processed yet
    public function didNotPayCount($from, $to);

    //get only users, who interacted in payment widget, filled their email and donation but didn't continue to payment
    public function onlyInitializeDonation($from, $to, $limit = null);
}