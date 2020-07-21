<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => mt_rand(1, 4),
        'nickname' => $faker->userName,
        'zip_code' => '904-0001',
        'address' => '那覇市久茂地1-2-3',
        'tel_no' => '098-861-'.mt_rand(1000, 9999),
        'birthday' => $faker->dateTimeBetween('-90 years', '-18 years')->format('Y/m/d'),
        'gender' => 1,
        'self_introduce' => '自己紹介です！'
    ];
});
