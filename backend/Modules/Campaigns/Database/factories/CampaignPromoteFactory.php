<?php

use Faker\Generator as Faker;

$factory->define(Modules\Campaigns\Entities\CampaignPromote::class, function (Faker $faker) {

  return [
    'start_date_value' => Carbon\Carbon::now(),
    'is_end_date' => true,
    'end_date_value' => Carbon\Carbon::now()->addDays(10),
    'donation_goal_value' => '5000'
  ];
});