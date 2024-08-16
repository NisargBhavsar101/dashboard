<!DOCTYPE html>
<html>
<head>
    <title>Traffic by Location</title>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Traffic by Location</h1>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script>
        function initMap() {
            // Map options
            var options = {
                zoom: 8,
                center: { lat: -34.397, lng: 150.644 }
            };
            // New map
            var map = new google.maps.Map(document.getElementById('map'), options);

            // Add marker
            var marker = new google.maps.Marker({
                position: { lat: -34.397, lng: 150.644 },
                map: map
            });
        }
    </script>
</body>
</html>
