<?php

namespace App;

use App\Traits\SupportsUuid;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

	use SupportsUuid;

	/**
	 * {@inheritDoc}
	 */
	public $timestamps = false;

	/**
	 * {@inheritDoc}
	 */
	public $incrementing = false;

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = ['name', 'type'];

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
}
