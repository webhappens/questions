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
            'message' => 'nullable|max:500',
        ]);

        $response = Response::create(
            $request->only([
                'question_id',
                'answer_id',
                'context_data',
                'message',
            ])
        );

        return response()->json([], 201);
    }
}
