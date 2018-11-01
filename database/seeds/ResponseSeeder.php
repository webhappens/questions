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
            $referer = $referers[array_rand($referers)];
            $referer->save();

            $response->referer()->associate($referer);
            $response->save();
        });
    }

    private function makeReferers()
    {
        for ($i = 0; $i < 20; $i++) {
            $referers[] = factory(Referer::class)->states('uri')->make();
        }

        for ($i=0; $i < 100; $i++) {
            $referers[] = factory(Referer::class)->states('url', 'with_path')->make();
        }

        for ($i = 0; $i < 25; $i++) {
            $referers[] = factory(Referer::class)->states('url', 'with_path', 'with_query')->make();
        }

        for ($i = 0; $i < 10; $i++) {
            $referers[] = factory(Referer::class)->states('url', 'with_path', 'with_query', 'with_fragment')->make();
        }

        for ($i = 0; $i < 10; $i++) {
            $referers[] = factory(Referer::class)->states('url', 'with_path', 'with_fragment')->make();
        }

        return $referers;
    }
}
