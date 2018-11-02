<?php

use Spatie\Url\Url;
use Faker\Generator as Faker;
use WebHappens\Questions\Referer;

$factory->define(Referer::class, function (Faker $faker) {
    return [];
});

$factory->state(Referer::class, 'uri', function (Faker $faker) {
    $uri = '/' . $faker->domainWord . '/' . $faker->domainWord;

    return Referer::makeFromString($uri)->toArray();
});

$factory->state(Referer::class, 'url', function (Faker $faker) {
    $url = Url::fromString(config('app.url'));
    $url .= '/' . $faker->slug;
    $url .= $faker->optional(0.25)->passthrough('?utm_source=example&utm_medium=email&utm_campaign=test');
    $url .= $faker->optional(0.1)->passthrough('#' . $faker->domainWord);

    return Referer::makeFromString($url)->toArray();
});
