<?php

namespace WebHappens\Questions\Http\Requests;

use WebHappens\Questions\Response;
use Illuminate\Foundation\Http\FormRequest;

class CreateResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question_id' => 'exists:questions,id',
            'answer_id' => 'exists:answers,id',
            'context_data' => 'nullable|json',
        ];
    }

    public function createResponse()
    {
        return Response::create(
            $this->only(['question_id', 'answer_id', 'context_data'])
        );
    }
}
