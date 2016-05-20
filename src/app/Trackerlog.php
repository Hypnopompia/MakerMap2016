<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trackerlog extends Model {
	use SoftDeletes;

	protected $table = 'trackerlogs';
	protected $fillable = [];
	protected $hidden = ['deleted_at'];
	protected $dates = ['deleted_at'];

	protected $casts = [
		'id' => 'integer',
		'tracker_id' => 'integer',
		'battery' => 'float',
		'latitude' => 'float',
		'longitude' => 'float',
	];

	public function tracker() {
		return $this->belongsTo('App\Tracker');
	}
}
