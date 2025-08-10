
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
  <title>About Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-cyan-100 min-h-screen font-sans">

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
   
  <button id="dropdownBtn" onclick="toggleDropdown()" class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-full shadow-md font-semibold text-sm transition-all duration-300">
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

  <!-- Main Content -->
  <div class="mt-20 px-6 max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl p-10">
      <h2 class="text-4xl font-bold text-center text-blue-600 mb-6">About Us</h2>
      
      <div class="space-y-8 text-gray-700 text-lg leading-relaxed">
        <div>
          <h3 class="text-2xl font-semibold text-gray-800 mb-2">Who We Are</h3>
          <p>
            AquaLeak is a community-driven platform dedicated to addressing water-related issues. We empower individuals to report leaked water taps and pipes in their neighborhoods — promoting awareness and enabling proactive solutions.
          </p>
        </div>

        <div>
          <h3 class="text-2xl font-semibold text-gray-800 mb-2">Our Mission</h3>
          <p>
            Our mission is to spread awareness and encourage collaboration to resolve water leakage issues. Together, we aim to conserve one of our most precious resources — water — through timely reporting and community support.
          </p>
        </div>

        <div>
         
        </div>
      </div>
    </div>
  </div>

</body>
</html>
<button id="dropdownBtn" onclick="toggleDropdown()" ...>User Name <i class="fas fa-user"></i></button>
<ul id="dropdownMenu" class="hidden absolute ...">
  <li><a href="user_complaint_list.php">📄 Complaint List</a></li>
  <li><a href="logout-user.php">🚪 Logout</a></li>
</ul>

<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  window.addEventListener('click', function(e) {
    const menu = document.getElementById('dropdownMenu');
    const button = document.getElementById('dropdownBtn');

    if (!button.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.add('hidden');
    }
  });
</script>
