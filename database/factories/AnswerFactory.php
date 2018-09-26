<?php

use WebHappens\Questions\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'text' => $faker->word(),
        'sentiment_id' => array_rand(Answer::sentiments()),
    ];
});

$factory->state(Answer::class, 'no', [
    'text' => 'No',
    'sentiment_id' => 1,
]);

$factory->state(Answer::class, 'yes', [
    'text' => 'Yes',
    'sentiment_id' => 2,
]);

$factory->state(Answer::class, 'not_really', [
    'text' => 'Not really',
    'sentiment_id' => 1,
]);

$factory->state(Answer::class, 'great', [
    'text' => 'It\'s great',
    'sentiment_id' => 2,
]);

$factory->state(Answer::class, 'love', [
    'text' => 'I love it!',
    'sentiment_id' => 3,
]);
