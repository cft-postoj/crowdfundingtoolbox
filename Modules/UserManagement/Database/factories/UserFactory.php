<?php

use Faker\Generator as Faker;

$factory->define(Modules\UserManagement\Entities\User::class, function (Faker $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'telephone' => $faker->phoneNumber,
        'password' => bcrypt('test123'),
        'username' => $faker->uuid

    ];
});

$factory->define(Modules\UserManagement\Entities\UserDetail::class, function (Faker $faker) {
    return [

        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'telephone' => $faker->phoneNumber,
        'address' => $faker->address,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,

    ];
});