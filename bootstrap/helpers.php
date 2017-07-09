<?php

use Illuminate\Support\Collection;

if ( ! function_exists('generate_stats_from_records')) {
    /**
     * Generate stats from records.
     *
     * @param  Collection $records
     * @return Collection
     */
    function generate_stats_from_records(Collection $records) : Collection
    {
        $total = $records->count();

        $uptime = $records->filter(function ($record){
            return $record->available == true;
        });

        $downtime = $records->filter(function ($record) {
            return $record->available == false;
        });

        // ------------------------------------------------------------------
        // Calculate the percentage.
        // ------------------------------------------------------------------
        $calculatePercentage = function (Collection $thing) use ($total) : int {
            if ($total <= 0) {
                return 0;
            }

            return  intval(round($thing->count() / ($total / 100)));
        };

        return new Collection([
            'records'             => $records,
            'uptime_percentage'   => $calculatePercentage($uptime),
            'downtime_percentage' => $calculatePercentage($downtime),
        ]);
    }
}

if ( ! function_exists('flash')) {
    /**
     * Shortcut because i am lazy.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    function flash($key, $value)
    {
        session()->flash($key, $value);
    }
}