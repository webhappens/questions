<?php

namespace WebHappens\Questions\Nova\Resources;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use WebHappens\Questions\Nova\Actions\Flag as FlagAction;
use WebHappens\Questions\Nova\Actions\Unflag as UnflagAction;
use WebHappens\Questions\Nova\Filters\Flagged as FlaggedFilter;
use WebHappens\Questions\Nova\Filters\Message as MessageFilter;
use WebHappens\Questions\Nova\Filters\Submitted as SubmittedFilter;
use WebHappens\Questions\Nova\Filters\Sentiment as SentimentFilter;

class Response extends BaseResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'WebHappens\Questions\Response';

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
    public static $search = [];

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'created_at' => 'desc'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->hideFromIndex()->hideFromDetail(),
            BelongsTo::make('Referer', 'referer', Referer::class),
            Text::make('Sentiment', 'answer')->resolveUsing(function ($answer) {
                return $answer->sentiment();
            }),
            Text::make('Submitted', 'created_at')->resolveUsing(function ($createdAt) {
                return $createdAt->diffForHumans();
            })->sortable()->hideFromDetail(),
            Text::make('Submitted', 'created_at')->resolveUsing(function ($createdAt) {
                return $createdAt->diffForHumans() . ' (' . $createdAt->toDayDateTimeString() . ')';
            })->sortable()->hideFromIndex(),
            BelongsTo::make('Question', 'question', Question::class)->hideFromIndex(),
            BelongsTo::make('Answer', 'answer', Answer::class)->hideFromIndex(),
            Text::make('Message', function () {
                return $this->message ? '✓' : '—';
            })->onlyOnIndex(),
            Text::make('Message')->onlyOnDetail(),
            // Textarea::make('Context data', 'context_data'),

            new Panel('Workflow', [
                Text::make('Flagged')->resolveUsing(function ($flagged) {
                    return $flagged ? '✓' : '—';
                }),
                Text::make('Flagged reason')->onlyOnDetail(),
            ]),
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
        return [
            new SentimentFilter,
            new SubmittedFilter,
            new MessageFilter,
            new FlaggedFilter,
        ];
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
        return [
            (new FlagAction)->canRun(function () {
                return true;
            }),
            (new UnflagAction)->canRun(function () {
                return true;
            }),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }
}
