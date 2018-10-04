<?php

namespace WebHappens\Questions\Http\Requests;

use WebHappens\Questions\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'message' => 'required|max:500',
        ];
    }

    public function updateResponse()
    {
        $response = $this->getResponse();
        $response->message = $this->get('message');
        $response->save();

        return $response;
    }

    private function getResponse()
    {
        $response = Response::findOrFail($this->route()->parameter('response'));

        abort_if($response->message, 403);

        return $response;
    }
}
