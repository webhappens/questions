<?php

namespace WebHappens\Questions\Seeds;

use Illuminate\Database\Seeder;
use WebHappens\Questions\Answer;
use WebHappens\Questions\Referer;
use WebHappens\Questions\Response;
use Illuminate\Support\Facades\Schema;

class ResponseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Response::truncate();
        Referer::truncate();
        Schema::enableForeignKeyConstraints();

        Answer::all()->each(function ($answer) {
            factory(Response::class, rand(50, 500))->create([
                'question_id' => $answer->question->id,
                'answer_id' => $answer->id,
            ]);
        });
    }
}
