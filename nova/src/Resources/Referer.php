<?php

namespace WebHappens\Questions\Nova\Resources;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use WebHappens\Questions\Nova\Filters\Submitted;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class Referer extends BaseResource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'WebHappens\Questions\Referer';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'uri',
    ];

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['responses'];

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'uri' => 'asc'
    ];

    public function title()
    {
        return $this->__toString();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex()->hideFromDetail(),
            Text::make('Referer', function () {
                return $this->__toString();
            }),
            Text::make('Latest Response', 'responses')->resolveUsing(function ($responses) {
                return $responses->sortByDesc('created_at')->first()->created_at->diffForHumans();
            }),
            NovaDependencyContainer::make([
                Text::make('Scheme')->onlyOnDetail(),
                Text::make('Host')->onlyOnDetail(),
                Text::make('Port')->onlyOnDetail(),
                Text::make('Path')->onlyOnDetail(),
                Text::make('Query')->resolveUsing(function ($query) {
                    return http_build_query($query);
                })->onlyOnDetail(),
                Text::make('Fragment')->onlyOnDetail(),
                ])->dependsOnNotEmpty('host'),
                Text::make('Type', function () {
                    return $this->host ? 'URL' : 'Custom';
                }),
                HasMany::make('Responses', 'responses', Response::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }
}
