<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Backend\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('??? ??????'),
        'guard_name' => 'web'
    ];
});
