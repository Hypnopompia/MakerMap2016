var particle = new Particle();
var map;

function initMap() {
	console.log('map init');
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 37.759018, lng: -122.3844139},
		zoom: 15, // 19
		mapTypeId: google.maps.MapTypeId.HYBRID
	});
}

particle.getEventStream({ name: 'makermap2016', auth: '200f73ada240a94f24001e0c9d4500683fce7777' }).then(function(stream) {

	stream.on('event', function(data) {
		console.log("Event: " + data);
	});

	stream.on('error', function(err) {
		console.log(err);
		// trigger full reconnection here
	});

});