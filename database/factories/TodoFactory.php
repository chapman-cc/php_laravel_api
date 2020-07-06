<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'todo_id'=> $faker->uuid,
        'todo'=> $faker->sentence(5),
        'completed'=> NULL
    ];
});
