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
    <title>Your Data</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="p-5">

<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16">
  <a href="home.php" class="text-3xl md:text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text">
    Aqua<span class="text-black">Leak</span>
  </a>

  <button id="menu-btn" class="block md:hidden focus:outline-none">
    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
      stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12" />
      <line x1="3" y1="6" x2="21" y2="6" />
      <line x1="3" y1="18" x2="21" y2="18" />
    </svg>
  </button>

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

<h1 class="text-3xl text-center font-bold mb-4 mt-20">Your Complaint History</h1>

<div class="container mx-auto">
  <div class="overflow-x-auto">
    <table class="min-w-[700px] w-full text-sm mt-10 rounded-lg overflow-hidden border border-gray-300">
      <?php
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        require 'connection.php';

        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $countQuery = "SELECT COUNT(*) as total FROM report WHERE email = '$email'";
            $countResult = mysqli_query($con, $countQuery);
            $totalRows = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($totalRows / $limit);

            $reportQuery = "SELECT report.*, status.status FROM report 
                            LEFT JOIN status ON report.id = status.complaint_id
                            WHERE report.email = '$email'
                            ORDER BY report.id DESC
                            LIMIT $limit OFFSET $offset";
            $reportData = mysqli_query($con, $reportQuery);

            if (mysqli_num_rows($reportData) > 0) {
                // Show table head only if there is data
                echo '<thead>
                        <tr class="bg-blue-500 text-white text-xs sm:text-sm">
                          <th class="py-2 px-4 bg-red-500">Complaint No</th>
                          <th class="py-2 px-4 bg-green-500">Details</th>
                          <th class="py-2 px-4 bg-yellow-500">Phone</th>
                          <th class="py-2 px-4 bg-purple-500">Location</th>
                          <th class="py-2 px-4 bg-green-500">Photo</th>
                          <th class="py-2 px-6 sm:px-32 bg-pink-500">Status</th>
                        </tr>
                      </thead>
                      <tbody>';

                $i = $offset + 1;
                while ($row = mysqli_fetch_assoc($reportData)) {
                    echo "<tr class='" . ($i % 2 == 0 ? "bg-blue-100" : "bg-blue-200") . "'>";
                    echo "<td class='text-center py-2 px-4 font-bold'>" . $row['id'] . "</td>";
                    echo "<td class='py-2 px-4'>" . $row['details'] . "</td>";
                    echo "<td class='text-center py-2 px-4'>" . $row['phone'] . "</td>";
                    echo "<td class='text-center py-2 px-4'>
                            <a href='https://www.google.com/maps?q={$row['location']}' target='_blank'>
                              <i class='fas fa-map-marker-alt text-green-600 text-lg'></i>
                            </a>
                          </td>";
                    echo "<td class='text-center py-2 px-4'>
                            <a href='{$row['photo']}' target='_blank'>
                              <i class='fas fa-image text-blue-500 text-lg'></i>
                            </a>
                          </td>";
                    $status = strtolower($row['status']);
                    echo "<td class='text-center py-2 px-4'>";
                    if ($status == 'not yet processed') {
                        echo "<span class='bg-red-500 text-white py-1 px-3 rounded-lg'>Not Processed Yet</span>";
                    } elseif ($status == 'pending' || $status == 'in process') {
                        echo "<span class='bg-yellow-500 text-white py-1 px-3 rounded-lg'>In Process</span>";
                    } elseif ($status == 'closed' || $status == 'resolved') {
                        echo "<span class='bg-green-500 text-white py-1 px-3 rounded-lg'>Resolved</span>";
                    } else {
                        echo "<span class='bg-gray-500 text-white py-1 px-3 rounded-lg capitalize'>$status</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</tbody>";
            } else {
                // No data, just show message row without head
                echo "<tbody>
                        <tr>
                          <td colspan='6' class='py-10 text-center text-gray-600 font-semibold text-lg'>
                            You have not registered any complaints yet.
                          </td>
                        </tr>
                      </tbody>";
            }
        } else {
            echo "<tbody>
                    <tr>
                      <td colspan='6' class='py-10 text-center text-red-600 font-semibold text-lg'>
                        You must be logged in to view your complaints.
                      </td>
                    </tr>
                  </tbody>";
        }
      ?>
    </table>

    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
      <div class="flex justify-center mt-6 space-x-3">
        <?php if($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Prev</a>
        <?php endif; ?>

        <?php for($p = 1; $p <= $totalPages; $p++): ?>
            <a href="?page=<?= $p ?>" class="px-4 py-2 rounded 
                <?= ($p == $page) ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                <?= $p ?>
            </a>
        <?php endfor; ?>

        <?php if($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
