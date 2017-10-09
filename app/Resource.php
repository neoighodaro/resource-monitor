<?php

namespace App;

use Carbon\Carbon;
use App\Traits\SupportsUuid;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

    use SupportsUuid;

    /**
     * {@inheritDoc}
     */
    public $incrementing = false;

    /**
     * {@inheritDoc}
     */
    protected $fillable = ['name', 'type','resource_starts','resource_ends','exclude_weekends'];

    /**
     * Get resource with records from date range.
     *
     * @param  Carbon $startDate
     * @param  Carbon $endDate
     * @return static|null
     */
    public function withRecordsWithinDateRange(Carbon $startDate, Carbon $endDate)
    {
        $resource_starts   = isset( $this->resource_starts) ?  $this->resource_starts : '00:00';
        $resource_ends     = isset( $this->resource_ends) ?  $this->resource_ends : '24:00';

        if ($this->exclude_weekends == 1) {
            return $this->whereId($this->id)->with(['records' => function ($record) use ($startDate, $endDate, $resource_starts, $resource_ends ) {
                $record->whereBetween('created_at', [$startDate->toDateString(), $endDate->addDay(1)->toDateString()])
                        ->whereRaw('TIME(created_at) >= ?', $resource_starts)
                        ->whereRaw('TIME(created_at) <= ?', $resource_ends)
                        ->whereRaw('WEEKDAY( DATE(created_at) ) < ?', 5)
                        ->orderBy('created_at', 'desc');
                }])->first();
        } else {
            return $this->whereId($this->id)->with(['records' => function ($record) use ($startDate, $endDate, $resource_starts, $resource_ends ) {
                $record->whereBetween('created_at', [$startDate->toDateString(), $endDate->addDay(1)->toDateString()])
                        ->whereRaw('TIME(created_at) >= ?', $resource_starts)
                        ->whereRaw('TIME(created_at) <= ?', $resource_ends)
                        ->orderBy('created_at', 'desc');
                }])->first();
        }

    }

    /**
     * Save a resource record
     */
    public function generateNewRecord()
    {
        return $this->records()->save(new ResourceRecord);
    }

    /**
     * Resource record relationship.
     */
    public function records()
    {
        return $this->hasMany(ResourceRecord::class);
    }

    /**
     * Gets an ordered list.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
