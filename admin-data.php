<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Data</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add CSS for table cells to show vertical lines */
        table td {
            border: 1px solid #e2e8f0; /* Adjust the border color as needed */
            padding: 8px;
            text-align: center;
        }
        /* Center the container and limit its width */
        .container {
           margin-left: 150px;
   
 
            max-width: 800px; /* Adjust the maximum width as needed */
        }
    </style>
</head>
<body class="p-5 ">
    <div class="container mt-20"> <!-- Center the container and set the maximum width -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16">
    <a href="admin.php" class="text-3xl md:text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text">
      Aqua<span class="text-black">Leak</span>
    </a>

    <nav class="flex items-center space-x-6">
    
      <a href="admin.html" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition duration-300 shadow font-medium">Logout</a>
    </nav>
  </header>
        <div class "overflow-x-auto ">
            <table class="table-auto rounded-lg w-full overflow-hidden mt-14 ">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="py-2 px-4 bg-red-500">Complaint_ID</th>
                        <th class="py-2 px-4 bg-green-500">Name</th>
                        
                        <th class="py-2 px-4 bg-yellow-500">Phone</th>
                        <th class="py-2 px-4 bg-purple-500">Location</th>
                        <th class="py-2 px-4 bg-green-500">Photo</th>
                        <th class="py-2 px-32 bg-pink-500">Status</th>
                        <th class="py-2 px-4 bg-green-500">Action</th>
                    </tr>
                </thead>
                <form method="post" action="admin-data.php">
                <tbody>
                    <?php
                    require 'connection.php';
$limit = 5; // rows per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of complaints
$totalQuery = "SELECT COUNT(*) as total FROM report";
$totalResult = mysqli_query($con, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

                    // Fetch report data
                   $reportQuery = "SELECT * FROM report LIMIT $limit OFFSET $offset";
                   $reportData = mysqli_query($con, $reportQuery);

                    // Fetch status data
                    $statusQuery = "SELECT * FROM status";
                    $statusData = mysqli_query($con, $statusQuery);

                    $statusArray = [];

                    while ($statusRow = mysqli_fetch_assoc($statusData)) {
                        $statusArray[$statusRow['complaint_id']] = $statusRow['status'];
                    }

                    $i = 1;
                    foreach ($reportData as $row) {
                        echo "<tr class='" . ($i % 2 == 0 ? "bg-blue-100" : "bg-blue-200") . "'>";
                        echo "<td class='py-2 px-4 font-bold'>$row[id]</td>";
                        echo "<td class='py-2 px-4'>$row[name]</td>";
                        
                        echo "<td class='py-2 px-4'>$row[phone]</td>";
                        echo "<td class='py-2 px-4' style='width:50px;height:50px;'>
                                <a href='https://www.google.com/maps?q=$row[location]' target='_blank'>
                                    <i class='fas fa-map-marker-alt text-green-500 text-lg'></i>
                                </a>
                            </td>";
                        echo "<td>
                            <a href='$row[photo]' target='_blank'>
                                <i class='fas fa-image image-logo'></i>
                            </a>
                        </td>";
                        // Display status based on the "complaint_id"
                        $status = strtolower($statusArray[$row['id']] ?? 'not yet processed');
            if ($status == 'not processed yet') {
                echo "<td class='py-2 px-4'><span class='bg-red-500 text-white py-1 px-2 rounded-lg'>Not Processed Yet</span></td>";
            } elseif ($status == 'in process') {
                echo "<td class='py-2 px-4'><span class='bg-yellow-500 text-white py-1 px-2 rounded-lg'>In Process</span></td>";
            } elseif ($status == 'closed' || $status == 'resolved') {
                echo "<td class='py-2 px-4'><span class='bg-green-500 text-white py-1 px-2 rounded-lg'>Closed/Resolved</span></td>";
            }
                
            elseif ($status == 'pending') 
            {
                    echo "<td class='py-2 px-4'><span class='bg-yellow-500 text-white py-1 px-2 rounded-lg'>Pending</span></td>";
            }
            else {
                echo "<td class='py-2 px-4'><span class='bg-gray-500 text-white py-1 px-2 rounded-lg'>$status</span></td>";
            }
            echo '<td class="py-2 px-2 whitespace-nowrap">';
            echo '<span class=" bg-green-500 text-black py-1 px-2 rounded-none">';
            echo '<a href="update-complaint.php?id=' . $row['id'] . '" class="rounded-none text-black hover:underline">Take Action</a>';
            echo '</span>';
            echo '</td>'; 
            

                        echo "</tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <div class="flex justify-center mt-6 space-x-2">
    <?php if($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Prev</a>
    <?php endif; ?>

    <?php for($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-3 py-1 rounded <?= ($i === $page) ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Next</a>
    <?php endif; ?>
</div>

        </div>
    </div>
   
    </form>
                
</body>
</html>
