<?php

use Faker\Generator as Faker;
use WebHappens\Questions\Referer;

$factory->define(Referer::class, function (Faker $faker) {
    return [];
});

$factory->state(Referer::class, 'uri', function (Faker $faker) {
    return [
        'uri' => '/' . $faker->domainWord . '/' . $faker->domainWord,
    ];
});

$factory->state(Referer::class, 'url', function (Faker $faker) {
    return [
        'scheme' => 'https',
        'host' => 'example.org',
    ];
});

$factory->state(Referer::class, 'with_port', function (Faker $faker) {
    return [
        'port' => 8080,
    ];
});

$factory->state(Referer::class, 'with_path', function (Faker $faker) {
    return [
        'path' => $faker->slug,
    ];
});

$factory->state(Referer::class, 'with_query', function (Faker $faker) {
    return [
        'query' => json_encode([
            'utm_source' => 'example',
            'utm_medium' => 'email',
            'utm_campaign' => 'test',
        ]),
    ];
});

$factory->state(Referer::class, 'with_fragment', function (Faker $faker) {
    return [
        'fragment' => '#' . $faker->domainWord,
    ];
});
