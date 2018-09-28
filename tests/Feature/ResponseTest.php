<?php

namespace WebHappens\Questions\Tests\Feature;

use WebHappens\Questions\Question;

class ResponseTest extends TestCase
{
    /** @test */
    public function can_store_post()
    {
        $response = $this->makeResponse();

        $this->post(route('questions.response.store'), $response)
            ->assertStatus(201);

        $this->assertDatabaseHas('responses', $response);
    }

    /** @test */
    public function it_requires_a_valid_question_id()
    {
        $response = $this->makeResponse();

        $response['question_id'] = 99;
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('question_id');

        $response['question_id'] = '';
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('question_id');

        $response['question_id'] = null;
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('question_id');
    }

    /** @test */
    public function it_requires_a_valid_answer_id()
    {
        $response = $this->makeResponse();

        $response['answer_id'] = 99;
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('answer_id');

        $response['answer_id'] = '';
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('answer_id');

        $response['answer_id'] = null;
        $this->post(route('questions.response.store'), $response)
            ->assertSessionHasErrors('answer_id');
    }

    private function makeResponse()
    {
        $question = factory(Question::class)->states('did_you_find')->create();
        $this->assertDatabaseHas('questions', $question->toArray());

        $answer = $question->answers->first();
        $this->assertDatabaseHas('answers', $answer->toArray());

        return [
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'context_data' => null,
        ];
    }
}
