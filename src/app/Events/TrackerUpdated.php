<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Tracker;

class TrackerUpdated extends Event implements ShouldBroadcast {

	private $tracker;

	public function __construct(Tracker $tracker) {
		$this->tracker = $tracker;
	}

	public function broadcastOn() {
		return [
			'trackers'
		];
	}

	public function broadcastWith() {
		return [
			'tracker' => $this->tracker
		];
	}
}