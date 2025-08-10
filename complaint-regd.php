<?php require_once "controllerUserData.php"; ?>
<?php 
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Registered</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="">
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16">
  <a href="home.php" class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text">
    Aqua<span class="text-black">Leak</span>
  </a>

  <nav class="flex items-center space-x-6 text-base font-semibold text-gray-700">
    <a href="home.php" class="font-bold hover:text-blue-600 transition">Home</a>
    <a href="about_us.php" class="font-bold hover:text-blue-600 transition">About</a>
    <a href="contact_us.php" class="font-bold hover:text-blue-600 transition">Contact</a>
    <a href="report.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition duration-300 shadow font-medium">Report</a>

    <div class="relative">
        
  <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-full shadow-md font-semibold text-sm transition-all duration-300">
      <?php echo explode(' ', $fetch_info['name'])[0]; ?>
      <i class="fas fa-user text-white text-sm"></i>
    </button>

      <ul id="dropdownMenu" class="hidden absolute right-0 mt-3 w-52 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden transition-all duration-300">
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
        <h1 class="text-4xl font-black text-gray-900 mb-4">Your Complaint Has Been Successfully Registered</h1>

        <?php
        $query = "SELECT * FROM report ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $lastEnteredComplaintID = $row['id'];
                echo "<p class='text-2xl font-black text-gray-900 mb-4'>Your Complaint Number: $lastEnteredComplaintID</p>";

                // Display complaint details in a table
                echo "<table class='bg-blue-500 table-auto rounded-lg w-full overflow-hidden'>";
                echo "<tr class=' text-black'>";
                echo "<th class='py-2 px-4  text-left'>Name</th>";
                
                echo "<th class='py-2 px-4  text-left'>Phone</th>";
                echo "<th class='py-2 px-4  text-left'>Location</th>";
                echo "<th class='py-2 px-4  text-left'>Details</th>";
                echo "<th class='py-2 px-4  text-left'>Photo</th>";
                echo "</tr>";
                echo "<tr class='bg-blue-100'>";
                echo "<td class='py-2 px-4'>$row[name]</td>";
               
                echo "<td class='py-2 px-4'>$row[phone]</td>";
                echo "<td class='py-2 px-4'><a href='https://www.google.com/maps?q=$row[location]' target='_blank'><i class='fas fa-map-marker-alt text-green-500 text-lg'></i></a></td>";
                echo "<td class='py-2 px-4'>$row[details]</td>";
                echo "<td>
                            <a href='$row[photo]' target='_blank'>
                                <i class='fas fa-image image-logo'></i>
                                </a>
                            </td>";
                echo "</tr>";
                echo "</table>";
            } else {
                echo "No complaints found.";
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }
        ?>
        
       <a href="home.php" class="text-blue-500 underline mt-4">Click here to go back to home</a>
        
    </div>
    
</body>
</html>
