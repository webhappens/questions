<?php

use WebHappens\Questions\Answer;
use WebHappens\Questions\Response;
use Illuminate\Database\Seeder;

class ResponseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Response::truncate();
        Schema::enableForeignKeyConstraints();

        Answer::all()->each(function ($answer) {
            factory(Response::class, rand(50, 500))->create([
                'question_id' => $answer->question->id,
                'answer_id' => $answer->id,
            ]);
        });
    }
}
