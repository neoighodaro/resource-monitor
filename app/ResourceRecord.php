<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceRecord extends Model {

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = ['available', 'resource_id'];

	/**
	 * {@inheritDoc}
	 */
	protected $casts = ['available' => 'boolean'];

	/**
	 * Record relationship.
	 */
	public function resource()
	{
		return $this->belongsTo(Record::class);
	}
}
