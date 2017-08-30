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
    protected $fillable = ['name', 'type'];

    /**
     * Get resource with records from date range.
     *
     * @param  Carbon $startDate
     * @param  Carbon $endDate
     * @return static|null
     */
    public function withRecordsWithinDateRange(Carbon $startDate, Carbon $endDate)
    {
        return $this->whereId($this->id)->with(['records' => function ($record) use ($startDate, $endDate) {
            $record->whereBetween('created_at', [$startDate->toDateString(), $endDate->addDay(1)->toDateString()])
                    ->whereRaw('TIME(created_at) >= ?', ['09:00:00'])
                    ->whereRaw('TIME(created_at) <= ?', ['17:30:00'])
                    ->orderBy('created_at', 'desc');
        }])->first();
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
