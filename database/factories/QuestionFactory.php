<?php

use Faker\Generator as Faker;
use WebHappens\Questions\Answer;
use WebHappens\Questions\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence(7, false),
    ];
});

$factory->state(Question::class, 'did_you_find', [
    'text' => 'Did you find what you were looking for?',
]);

$factory->afterCreatingState(Question::class, 'did_you_find', function ($question, $faker) {
    $question->answers()->saveMany([
        factory(Answer::class)->states('no')->make(),
        factory(Answer::class)->states('yes')->make(),
    ]);
});

$factory->state(Question::class, 'are_you_enjoying', [
    'text' => 'Are you enjoying using the app?',
]);

$factory->afterCreatingState(Question::class, 'are_you_enjoying', function ($question, $faker) {
    $question->answers()->saveMany([
        factory(Answer::class)->states('not_really')->make(),
        factory(Answer::class)->states('great')->make(),
        factory(Answer::class)->states('love')->make(),
    ]);
});
