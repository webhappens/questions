<?php

namespace WebHappens\Questions\Tests\Feature;

use WebHappens\Questions\Question;

class ResponseTest extends TestCase
{
    private $question;
    private $answer;

    protected function setUp()
    {
        parent::setUp();

        $this->question = factory(Question::class)->states('did_you_find')->create();
        $this->assertDatabaseHas('questions', $this->question->toArray());

        $this->answer = $this->question->answers->last();
        $this->assertDatabaseHas('answers', $this->answer->toArray());
    }

    /** @test */
    public function can_store_without_context_data()
    {
        $fields = $this->validFields();

        $this->store($fields)
            ->assertStatus(201);

        $this->assertDatabaseHas('responses', $fields);
    }

    /** @test */
    public function can_store_with_context_data()
    {
        $fields = $this->validFields(['context_data' => json_encode(['referer' => 'https://example.org'])]);

        $this->store($fields)
            ->assertStatus(201);

        $this->assertDatabaseHas('responses', $fields);
    }

    /** @test */
    public function store_requires_a_valid_question_id()
    {
        $fields = $this->validFields(['question_id' => 99]);

        $this->store($fields)
            ->assertStatus(422)
            ->assertJsonValidationErrors('question_id');
    }

    /** @test */
    public function store_requires_a_valid_answer_id()
    {
        $fields = $this->validFields(['answer_id' => 99]);

        $this->store($fields)
            ->assertStatus(422)
            ->assertJsonValidationErrors('answer_id');
    }

    /** @test */
    public function store_requires_valid_context_data()
    {
        $fields = $this->validFields(['context_data' => 'not-null-or-json']);

        $this->store($fields)
            ->assertStatus(422)
            ->assertJsonValidationErrors('context_data');
    }

    /** @test */
    public function can_update_with_message()
    {
        $fields = $this->validFields();
        $response = $this->store($fields);
        $message = 'I like your app!';

        $this->update($response->getData()->id, compact('message'))
            ->assertStatus(200);

        $this->assertDatabaseHas('responses', array_merge($fields, compact('message')));
    }

    /** @test */
    public function update_requires_a_valid_message()
    {
        $fields = $this->validFields();
        $response = $this->store($fields);

        $this->update($response->getData()->id, ['message' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');

        $this->update($response->getData()->id, ['message' => str_random(501)])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }

    /** @test */
    public function update_is_forbidden_if_message_already_exists()
    {
        $fields = $this->validFields();
        $response = $this->store($fields);
        $message = 'I like your app!';

        $this->update($response->getData()->id, compact('message'));

        $this->update($response->getData()->id, compact('message'))
            ->assertStatus(403);
    }

    /** @test */
    public function update_throws_a_404_if_response_doesnt_exist()
    {
        $this->update(99, ['message' => 'A test message'])
            ->assertStatus(404);
    }

    private function store(array $fields)
    {
        return $this->json('POST', route('questions.response.store'), $fields);
    }

    private function update($id, array $fields)
    {
        return $this->json('PUT', route('questions.response.update', $id), $fields);
    }

    private function validFields(array $overrides = [])
    {
        return array_merge([
            'question_id' => $this->question->id,
            'answer_id' => $this->answer->id,
            'context_data' => null,
        ], $overrides);
    }
}
