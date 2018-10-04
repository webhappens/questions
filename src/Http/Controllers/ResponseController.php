<?php

namespace WebHappens\Questions\Http\Controllers;

use Illuminate\Routing\Controller;
use WebHappens\Questions\Http\Requests\CreateResponseRequest;
use WebHappens\Questions\Http\Requests\UpdateResponseRequest;

class ResponseController extends Controller
{
    public function store(CreateResponseRequest $request)
    {
        return response()->json($request->createResponse(), 201);
    }

    public function update(UpdateResponseRequest $request)
    {
        return response()->json($request->updateResponse());
    }
}
