<?php

namespace WebHappens\Questions\Http\Requests;

use WebHappens\Questions\Referer;
use WebHappens\Questions\Response;
use Illuminate\Foundation\Http\FormRequest;

class CreateResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question_id' => 'exists:questions,id',
            'answer_id' => 'exists:answers,id',
            'referer' => 'string|nullable|max:2000',
            'context_data' => 'json|nullable',
        ];
    }

    public function createResponse()
    {
        $attributes = $this->only(['question_id', 'answer_id', 'context_data']);

        if ($referer = $this->get('referer')) {
            $referer = Referer::firstOrCreateFromString($referer);
            $attributes = array_merge($attributes, ['referer_id' => $referer->id]);
        }

        return Response::create($attributes);
    }
}
