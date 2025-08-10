<?php
require 'connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: login-user.php');
    exit;
}
// Initialize variables for error and success messages
$errorMessage = "";
$successMessage = "";

if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize inputs
    $name = $_POST["name"];
    $status='pending';
    $email=$_SESSION["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $location = $_POST["location"];
    $details = $_POST["details"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $file = $_FILES["photo"];
 // print_r($file);
    $filename = $file['name'];
  $filepath = $file['tmp_name'];
   $fileerror = $file['error'];
    if ($fileerror == 0) {
        $destfile = 'upload/'. $filename;
       // echo $destfile;
       move_uploaded_file($filepath,$destfile);
      $status_insert_query="INSERT INTO status (name,status,email)VALUES('$name','$status','$email')";
      $status_query_result=mysqli_query($con,$status_insert_query);
      $insert_query = "INSERT INTO report (name, email,phone, address, location, details, latitude, longitude,photo) 
                    VALUES ('$name','$email', '$phone', '$address', '$location', '$details', '$latitude', '$longitude','$destfile')";
    $query=mysqli_query($con, $insert_query);
    
}
if (!$status_query_result) {
    die("Error in status_query: " . mysqli_error($con));
}

if ($query) {
    // Data has been successfully inserted
   $successMessage = "Your Complaint Has Been Registered.";
    header("Location: complaint-regd.php");
exit();
} else {
    // Error occurred while inserting data
    $errorMessage = "Failed while Submitting Form: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
}
?>
<!-- Success Message -->
<?php
// Commenting out the success message section
/*
if (isset($successMessage)): ?>
<div class="bg-green-200 mt-10 max-w-md font-bold mx-auto bg-white p-6 rounded-md shadow-md ">
    <?php echo $successMessage; ?>
</div>
<?php endif;
*/

// Commenting out the error message section
/*
if (isset($errorMessage)): ?>
<div class="font-semibold bg-red-500 max-w-md mx-auto bg-white p-6 rounded-md shadow-md ">
    <?php echo $errorMessage; ?>
</div>
<?php endif;
*/
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body {
            background-image: url('Image/image(4).jpg'); /* Replace 'background.jpg' with the actual file name and path */
            background-size: 50%;
            background-repeat: no-repeat;
            background-attachment: fixed;
            
        }
        .background-image {
        float: right; /* Move the image to the right */
        margin-left: 80px; /* Adjust the left margin to control its placement */
    }
    </style>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body onload=getLocation()  class=" p-8 ">


    <div class=" mx-auto max-w-md  p-6 rounded-lg  shadow-md">
        
        
        <form class="myForm" action="report.php" method="POST" enctype="multipart/form-data" >
            <div class="mb-4">
                <label for="name" class="block text-gray-600 font-medium">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="phone" class="block text-gray-600 font-medium">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Your Phone Number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="address" class="block text-gray-600 font-medium">Enter Your Address</Address></label>
                <input type="text" id="address" name="address" placeholder="Your Address" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
    <label for="location" class="block text-gray-600 font-medium">Location of Water Leakage</label>
    <input type="text" id="location" name="location" placeholder="Location of Leakage" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
    
</div>
<div id="map" style="height: 300px;">
</div>
            <div class="mb-4">
                <label for="detail" class="block text-gray-600 font-medium">Enter Details</label>
                <textarea id="detail" name="details" rows="4" cols="50" placeholder="Enter Details Here"></textarea>
            </div>
            <div class="mb-4">
                
                <input type="hidden" id="latitude" name="latitude" placeholder="latitude" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                
                <input type="hidden" id="longitude" name="longitude" placeholder="longitude" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                
                <input  type="file" id="photo" name="photo"  placeholder="upload the image" class=" px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <input type="hidden" id="date" name="date" value="" />
            <div class="mt-6">
                <button type="submit" name="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Submit</button>
            </div>
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

    var marker = null; // Variable to store the marker

    // Add a click event listener to the map
    map.on('click', function (e) {
        // Get latitude and longitude
        var latitude = e.latlng.lat;
        var longitude = e.latlng.lng;

        // Remove the previous marker, if it exists
        if (marker) {
            map.removeLayer(marker);
        }

        // Create a new marker
        marker = L.marker([latitude, longitude]).addTo(map);

        // Make a request to the OpenCage API to get location information
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=2ab6ae68bd1146468e8af8d37a7b4594`)
            .then(response => response.json())
            .then(data => {
                if (data.results.length > 0) {
                    var locationName = data.results[0].formatted;
                    locationInput.value = locationName;
                } else {
                    alert("Location not found.");
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
    
</script>

    </body>
    </html>

