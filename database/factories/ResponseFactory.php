<?php

use WebHappens\Questions\Response;
use Faker\Generator as Faker;

$factory->define(Response::class, function (Faker $faker) {
    return [
        'message' => $faker->paragraph(),
    ];
});
