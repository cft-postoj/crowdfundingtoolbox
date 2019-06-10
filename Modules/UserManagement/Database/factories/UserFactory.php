<?php
use Faker\Generator as Faker;

$factory->define(Modules\UserManagement\Entities\User::class, function (Faker $faker) {

  return [
    'first_name' => $faker->firstName,
    'last_name'=> $faker->lastName,
    'email'=> $faker->email,
    'telephone'=> $faker->phoneNumber,
    'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
    'username' => $faker->uuid

  ];
});