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

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $fetch_info['name'] ?> | Home</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Loader (only 1 div) -->
<div id="loader" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
  <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
</div>

<!-- Header -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16">
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
   

   <ul id="dropdownMenu" class="hidden absolute right-0 left-auto mt-3 w-52 max-w-xs bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden transition-all duration-300">

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

<script>
function toggleDropdown() {
  document.getElementById('dropdownMenu').classList.toggle('hidden');
}
document.addEventListener('click', function (e) {
  const dropdown = document.getElementById('dropdownMenu');
  const button = e.target.closest('button');
  if (!dropdown.contains(e.target) && !button) {
    dropdown.classList.add('hidden');
  }
});
</script>

<!-- Main Section -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-green-100 to-white px-6 py-20">
  <div class="flex flex-col md:flex-row items-center justify-between w-full max-w-7xl bg-white p-10 rounded-3xl shadow-2xl border border-gray-200">
    
    <!-- Left Text & Form -->
    <div class="md:w-1/2 space-y-8">
      <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight text-gray-900">
        <span class="block">Track and Report</span>
        <span class="block text-blue-600">Leaky Water Taps</span>
        <span class="block text-green-600">with <span class="text-emerald-600">AquaLeak</span></span>
      </h1>

      <form id="trackForm" method="POST" action="track-complaint.php" onsubmit="return showLoader()" ...>

          <input type="text" name="complaintid" id="complaintid" placeholder="Complaint Number..." required 
            class="p-4 rounded-xl border border-gray-300 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
          <button type="submit" name="tracksubmit" 
            class="bg-gradient-to-r from-blue-600 to-emerald-500 text-white px-6 py-3 rounded-xl font-bold shadow-md hover:from-blue-700 hover:to-emerald-600 transition duration-300">
            Track
          </button>
        </form>
      </div>

      <!-- Right Image -->
      <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
        <img src="Images/image(4).jpg" alt="Leaky Tap" class="rounded-2xl shadow-xl border border-gray-200 w-full max-w-sm">
      </div>
    </div>
  </div>

  <script>
 function showLoader() {
  let value = document.getElementById("complaintid").value;

  if (!/^\d+$/.test(value)) {
    alert("Please enter numbers only.");
    return false;
  }

  // Show loader
  document.getElementById("loader").classList.remove("hidden");

  // Allow form to submit normally after showing loader
  return true; // this lets form submit proceed normally
}
const menuBtn = document.getElementById('menu-btn');
  const menu = document.getElementById('menu');

  menuBtn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
  });

  function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
  }

  // Close dropdown when clicked outside
  document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('dropdownMenu');
    const button = e.target.closest('button');
    if (!dropdown.contains(e.target) && !button) {
      dropdown.classList.add('hidden');
    }
  });
  </script>   

</body>
</html>
