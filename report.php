<?php
require 'connection.php';
session_start();

$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login-user.php');
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
<body onload=getLocation()  class=" p-20 ">
<header class="fixed top-0 left-0 right-0 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16" style="z-index: 9999;">
  <a href="home.php" class="text-3xl md:text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text">
    Aqua<span class="text-black">Leak</span>
  </a>

  <!-- Hamburger button for mobile -->
  <button id="menu-btn" class="block md:hidden focus:outline-none">
    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
      stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12" />
      <line x1="3" y1="6" x2="21" y2="6" />
      <line x1="3" y1="18" x2="21" y2="18" />
    </svg>
  </button>

  <!-- Navigation menu -->
 <nav id="menu" class="hidden md:flex flex-col md:flex-row md:items-center md:space-x-6 space-y-3 md:space-y-0 p-4 md:p-0 w-full md:w-auto bg-white md:bg-transparent rounded-lg md:rounded-none shadow md:shadow-none">
  <a href="home.php" class="font-bold hover:text-blue-600 transition">Home</a>
  <a href="about_us.php" class="font-bold hover:text-blue-600 transition">About</a>
  <a href="contact_us.php" class="font-bold hover:text-blue-600 transition">Contact</a>
  <a href="report.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition duration-300 shadow font-medium">Report</a>

  <div class="relative">
   
  <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-full shadow-md font-semibold text-sm transition-all duration-300">
      <?php echo explode(' ', $fetch_info['name'])[0]; ?>
      <i class="fas fa-user text-white text-sm"></i>
    </button>
   

    <ul id="dropdownMenu" class="hidden absolute md:right-0 right-auto left-0 mt-3 w-52 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden transition-all duration-300">
      <li>
        <a href="user_complaint_list.php" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">📄 Complaint List</a>
      </li>
      <li>
        <a href="logout-user.php" class="block px-6 py-3 text-sm text-gray-700 hover:bg-red-100 hover:text-red-600 transition">🚪 Logout</a>
      </li>
    </ul>
  </div>
</nav>

</header>

    <div class=" mx-auto max-w-md p-6 rounded-lg shadow-md ">
        
        
        <form class="myForm mt-12"  action="report.php" method="POST" enctype="multipart/form-data" onsubmit="return handleSubmit(event)" >
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
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=cde866fe4d8a4ecfaa9242a13e1284e5`)
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
   function handleSubmit(e) {
  e.preventDefault(); // form submit roko

  showLoader();

  alert("Complaint Registered Successfully!");

  setTimeout(() => {
    hideLoader();
    // JS se redirect kar do yahan
    window.location.href = 'complaint-regd.php';
  }, 2000);

  return false;
}

function showLoader() {
  if (!document.getElementById('loader')) {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.style.position = 'fixed';
    loader.style.top = '0';
    loader.style.left = '0';
    loader.style.width = '100vw';
    loader.style.height = '100vh';
    loader.style.background = 'rgba(0,0,0,0.5)';
    loader.style.display = 'flex';
    loader.style.justifyContent = 'center';
    loader.style.alignItems = 'center';
    loader.style.zIndex = '10000';

    loader.innerHTML = `
      <div class="loader-spinner" style="
        border: 8px solid #f3f3f3; 
        border-top: 8px solid #3498db; 
        border-radius: 50%; 
        width: 60px; 
        height: 60px; 
        animation: spin 1s linear infinite;">
      </div>
      <style>
        @keyframes spin {
          0% { transform: rotate(0deg);}
          100% { transform: rotate(360deg);}
        }
      </style>
    `;
    document.body.appendChild(loader);
  }
}

function hideLoader() {
  const loader = document.getElementById('loader');
  if (loader) {
    loader.remove();
  }
}

    
</script>

    </body>
    </html>

