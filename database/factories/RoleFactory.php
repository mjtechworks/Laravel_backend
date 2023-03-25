<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Backend\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('??? ??????')
    ];
});
