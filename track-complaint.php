

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Track</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: center;
        }
        .container {
            margin: 0 auto;
            max-width: 800px;
        }
    </style>
</head>
<body class="p-5">

<div class="container mx-auto">
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
<?php
require 'connection.php';

if (isset($_POST['tracksubmit'])) {
    $complaintid = $_POST["complaintid"];
    $rows = mysqli_query($con, "SELECT * FROM status WHERE complaint_id=$complaintid");

    if (mysqli_num_rows($rows) > 0) {
        $resolved = false;
        foreach ($rows as $row) {
            if (strtolower($row['status']) === 'resolved') {
                $resolved = true;
            }
            echo "<h1 class='text-2xl text-black font-bold text-center'>Complaint Tracking Details</h1><br>";
            break; // Only need to show once
        }
?>


<table class="table-auto rounded-lg w-full overflow-hidden mt-10">
    <thead>
        <tr class="bg-blue-500 text-white">
            <th class="py-2 px-4 bg-green-500">Complaint_ID</th>
            <th class="py-2 px-4 bg-green-500">Complainant_Name</th>
            <th class="py-2 px-4 bg-green-500">Date</th>
            <th class="py-2 px-4 bg-green-500">Status</th>
            <?php if ($resolved) { echo '<th class="py-2 px-4 bg-green-500">Feedback</th>'; } ?>
        </tr>
    </thead>
    <tbody>
    <?php
        $i = 1;
        foreach ($rows as $row) {
            echo "<tr class='" . ($i % 2 == 0 ? "bg-blue-100" : "bg-blue-200") . "'>";
            echo "<td class='py-2 px-4 font-bold'>{$row['complaint_id']}</td>";
            echo "<td class='py-2 px-4'>{$row['name']}</td>";
            $formattedDate = date("d F, h:i A", strtotime($row['date']));
            echo "<td class='py-2 px-4'>{$formattedDate}</td>";

            $status = $row['status'];

            if ($status === 'Not Processed Yet') {
                echo "<td class='py-2 px-4'><span class='bg-red-500 text-white py-1 px-2 rounded-lg'>Not Processed Yet</span></td>";
            } elseif ($status === 'in process' || $status === 'pending') {
                echo "<td class='py-2 px-4'><span class='bg-yellow-500 text-white py-1 px-2 rounded-lg capitalize'>{$status}</span></td>";
            } elseif ($status === 'closed' || strtolower($status) === 'resolved') {
                echo "<td class='py-2 px-4'><span class='bg-green-500 text-white py-1 px-2 rounded-lg'>Closed/Resolved</span></td>";
            } else {
                echo "<td class='py-2 px-4'><span class='bg-gray-500 text-white py-1 px-2 rounded-lg'>{$status}</span></td>";
            }

            if ($resolved) {
                echo '<td class="py-2 px-4"><span class="bg-red-500 text-white py-1 px-2 rounded-lg"><a href="feedback.php?id=' . $row['complaint_id'] . '">Feedback</a></span></td>';
            }

            echo "</tr>";
            $i++;
        }
    ?>
    </tbody>
</table>

<?php
    } else {
        echo "<div class='mx-auto text-center  '>";
        echo "<div class='bg-red-500 text-white inline-block py-5 px-4 rounded-lg mt-20'>";
        echo "No Records found towards details provided. Please verify data entered.";
        echo "</div></div>";
    }
}
?>

</div>

<br>
<div class="text-center mx-auto">
    <a href="home.php" class="rounded-lg bg-blue-500 text-white py-2 px-4">Back</a>
</div>

</body>
</html>
