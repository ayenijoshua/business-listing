<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Listing;
use Faker\Generator as Faker;

$factory->define(Listing::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->realText(100,2),
        'email'=>$faker->email,
        'url'=>$faker->url,
        'address'=>$faker->realText(100,2),
        'phones'=>$faker->numberBetween(1000,9000)
    ];
});
