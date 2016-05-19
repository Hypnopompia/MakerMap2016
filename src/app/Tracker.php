<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Events\TrackerUpdated;

class Tracker extends Model {
	use SoftDeletes;

	protected $table = 'trackers';
	protected $fillable = [];
	protected $hidden = ['deleted_at'];
	protected $dates = ['deleted_at'];

	protected $casts = [
		'id' => 'integer',
		'enabled' => 'boolean',
		'battery' => 'float',
		'latitude' => 'float',
		'longitude' => 'float',
	];

	public static function boot() {
		parent::boot();

		Tracker::saved(function ($tracker) {
			event(new TrackerUpdated($tracker));
		});
	}
}
