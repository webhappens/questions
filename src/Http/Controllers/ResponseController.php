<?php

namespace WebHappens\Questions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebHappens\Questions\Response;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'exists:questions,id',
            'answer_id' => 'exists:answers,id',
            'context_data' => 'nullable|json',
        ]);

        Response::create(
            $request->only(['question_id', 'answer_id', 'context_data'])
        );

        return response()->json([], 201);
    }

    public function update(Request $request, Response $response)
    {
        $request->validate([
            'message' => 'required|max:500',
        ]);

        $response->message = $request->get('message');

        $response->save();

        return response()->json();
    }
}
