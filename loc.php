<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Form</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-4">Enter Location</h1>
        <form action="process_location.php" method="POST">
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-600">Location:</label>
                <input type="text" id="location" name="location" class="w-full mt-2 p-2 border rounded-md" placeholder="Click here to select a location on Google Maps" required>
            </div>
            <div id="map" style="height: 300px;"></div>
            <button type="submit" class="bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </form>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>
    <script>
        var locationInput = document.getElementById('location');
        var autocomplete = new google.maps.places.Autocomplete(locationInput);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (place.formatted_address) {
                locationInput.value = place.formatted_address;
            }
        });
    </script>

    <script>

        
        // Leaflet map initialization
        var map = L.map('map').setView([15.286691, 73.969780], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a click event listener to the map
        map.on('click', function (e) {
            alert("Latitude: " + e.latlng.lat + "\nLongitude: " + e.latlng.lng);
        });
    </script>
</body>
</html>
