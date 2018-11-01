<?php

namespace WebHappens\Questions\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use WebHappens\Questions\Answer;

class Sentiment extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->whereHas('answer', function ($query) use ($value) {
            $query->where('sentiment_id', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return array_flip(Answer::sentiments());
    }
}
