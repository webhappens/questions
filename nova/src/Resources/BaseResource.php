<?php

namespace WebHappens\Questions\Nova\Resources;

use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class BaseResource extends NovaResource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Ask Questions';

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'id' => 'desc'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        return $query;
    }
}
