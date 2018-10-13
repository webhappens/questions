<?php

use Faker\Generator as Faker;
use WebHappens\Questions\Referer;
use WebHappens\Questions\Response;

$factory->define(Response::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-2 weeks');
    $referer = factory(Referer::class)->states('url', 'with_path')->create();

    return [
        'referer_id' => $referer->id,
        'message' => $faker->paragraph(),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
