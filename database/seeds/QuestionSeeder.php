<?php

use WebHappens\Questions\Answer;
use WebHappens\Questions\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Question::truncate();
        Answer::truncate();
        Schema::enableForeignKeyConstraints();

        factory(Question::class)->states('did_you_find')->create();
        factory(Question::class)->states('are_you_enjoying')->create();
    }
}
