<?php

use Faker\Generator as Faker;
use WebHappens\Questions\Response;

$factory->define(Response::class, function (Faker $faker) {
    return [
        'message' => $faker->paragraph(),
    ];
});
