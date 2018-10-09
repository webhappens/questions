<?php

namespace WebHappens\Questions\Nova\Http\Middleware;

use Webhappens\Questions\Tool;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(Tool::class)->authorize($request) ? $next($request) : abort(403);
    }
}
