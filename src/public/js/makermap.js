var map;
var trackers;
var markers = [];

function initMap() {
	console.log('map init');
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 37.753849, lng: -122.389618},
		zoom: 17, // 19
		mapTypeId: google.maps.MapTypeId.ROADMAP // HYBRID
	});

	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('legend'));

	$.get('/tracker.list', function(data){
		trackers = data.trackers;
		displayTrackers();
	});

	// var myloc = new google.maps.Marker({
	// 	clickable: false,
	// 	icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
	// 													new google.maps.Size(22,22),
	// 													new google.maps.Point(0,18),
	// 													new google.maps.Point(11,11)),
	// 	shadow: null,
	// 	zIndex: 999,
	// 	map: map// your google.maps.Map object
	// });

	// setInterval(function(){
	// 	if (navigator.geolocation) navigator.geolocation.getCurrentPosition(function(pos) {
	// 		var me = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
	// 		myloc.setPosition(me);
	// 	}, function(error) {
	// 		// ...
	// 	});
	// }, 5000);


}

function displayTrackers() {
	clearMarkers();
	$('#legend').empty();
	$.each(trackers, function(id, tracker){
		console.log(tracker);
		var location=new google.maps.LatLng(tracker.latitude, tracker.longitude);

		marker = new google.maps.Marker({
			position: location,
			draggable: false,
			icon: tracker.icon
		});

		markers.push(marker);

		marker.setMap(map);
		map.panTo(marker.getPosition());


		$('#legend').append('<img src="' + tracker.icon + '" /> ' + tracker.name + ' - ' + tracker.battery + '%<br/>');
	});
}

function clearMarkers() {
	for (var i = 0; i < markers.length; i++ ) {
		markers[i].setMap(null);
	}
	markers.length = 0;
}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('0c0967444f7e2687dcdd', {
	encrypted: true
});

var channel = pusher.subscribe('trackers');
channel.bind('App\\Events\\TrackerUpdated', function(data) {
	trackers[data.tracker.id] = data.tracker;
	displayTrackers();
});