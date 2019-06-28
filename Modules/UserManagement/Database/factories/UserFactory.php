<?php
use Faker\Generator as Faker;
$factory->define(Modules\UserManagement\Entities\User::class, function (Faker $faker) {
    $email = $faker->email;
    return [
        'email' => $email,
        'username' => explode("@",$email)[0].$faker->uuid,
        'password' => bcrypt('test123')
    ];
});
$factory->define(Modules\UserManagement\Entities\UserDetail::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'telephone' => $faker->phoneNumber,
        'street' => $faker->streetName,
        'house_number' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,
    ];
});
