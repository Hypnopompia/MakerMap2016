<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Events\TrackerUpdated;

use Carbon\Carbon;

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
			if ($tracker->enabled) {
				event(new TrackerUpdated($tracker));
			}
		});
	}

	public function scopeUpToDate($query) {
		return $query->where('updated_at', '>=', Carbon::now()->subMinutes(60)->toDateTimeString());
	}
}
