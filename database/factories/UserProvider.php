<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;


$factory->define(App\UserProvider::class, function (Faker $faker) {
    return [
        'balance' => '300',
        'currency' => 'USD',
        'email' => $faker->unique()->safeEmail, 
        'status' => '1',
        'registeration_date' => now(), 
        'identification' => '4fc3-a8d2',
        'provider'=> 'DataProviderY'
    ];
});

