<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Log;

use App\Tracker;

class TrackerController extends Controller
{
	public function __construct() {
	}

	public function listtrackers(Request $request) {
		return response()->json([ 'ok' => true, 'trackers' => Tracker::where('enabled', true)->get()->keyBy('id') ]);
	}

	public function update(Request $request) {
		$validator = Validator::make($request->all(), [
			'coreid' => 'required',
			'data' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['ok' => false, 'errors' => $validator->errors() ]);
		}

		Log::info($request);

		$deviceid = $request->coreid;
		$data = explode(",", $request->data);
		$lat = $data[0];
		$lon = $data[1];
		$batt = $data[2];
		$name = $data[3];

		$tracker = Tracker::where('deviceid', $deviceid)->first();

		if (!$tracker) {
			$tracker = new Tracker;
			$tracker->deviceid = $deviceid;
		}

		$tracker->latitude = $lat;
		$tracker->longitude = $lon;
		$tracker->battery = $batt;
		$tracker->name = $name;
		$tracker->save();

		return response()->json([ 'ok' => true, 'tracker' => $tracker ]);
	}
}
