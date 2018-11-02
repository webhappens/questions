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

        $referers = $this->makeReferers();

        Response::all()->each(function ($response) use ($referers) {
            if ($referer = $referers[array_rand($referers)]) {
                $referer->save();

                $response->referer()->associate($referer);
                $response->save();
            }
        });
    }

    private function makeReferers()
    {
        for ($i = 0; $i < 10; $i++) {
            $referers[] = null;
        }

        $referers[] = factory(Referer::class, 20)->states('uri')->make();
        $referers[] = factory(Referer::class, 100)->states('url')->make();

        return array_flatten($referers);
    }
}
