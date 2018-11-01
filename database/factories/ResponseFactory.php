<?php

use Faker\Generator as Faker;
use WebHappens\Questions\Referer;
use WebHappens\Questions\Response;

$factory->define(Response::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-2 weeks');

    return [
        'message' => $faker->paragraph(),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
