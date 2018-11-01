<?php

namespace WebHappens\Questions\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class DateRange extends Filter
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
        return $query->whereBetween(
            $query->getModel()->getTable() . '.created_at',
            $this->currentRange($value)
        );
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Today' => 0,
            'Since Yesterday' => 1,
            'Last 7 Days' => 7,
            'Last 14 Days' => 14,
            'Last 30 Days' => 30,
            'Last 60 Days' => 60,
            'Last 365 Days' => 365,
            'Month To Date' => 'MTD',
            'Quarter To Date' => 'QTD',
            'Year To Date' => 'YTD',
        ];
    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int  $range
     * @return array
     */
    protected function currentRange($range)
    {
        if ($range == 'MTD') {
            return [
                now()->firstOfMonth(),
                now(),
            ];
        }

        if ($range == 'QTD') {
            return [
                Carbon::firstDayOfQuarter(),
                now(),
            ];
        }

        if ($range == 'YTD') {
            return [
                now()->firstOfYear(),
                now(),
            ];
        }

        return [
            now()->subDays($range),
            now(),
        ];
    }
}
