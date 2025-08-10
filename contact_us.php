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
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us | AquaLeak</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- For icons -->
  <style>
  .loader-spinner {
    width: 64px;
    height: 64px;
    border: 6px solid #7c3aed; /* Purple border */
    border-top: 6px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Header -->
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

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center pt-20 px-4 sm:px-6 lg:px-8">
    <div class="bg-white p-10 rounded-xl shadow-lg max-w-lg w-full">
      <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Get in Touch</h1>
      <form method="POST" action="" class="space-y-6" onsubmit="return handleSubmit(event)">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input
            type="text"
            id="name"
            name="name"
            placeholder="Your Name"
            required
            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none transition"
          />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Your Email"
            required
            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none transition"
          />
        </div>

        <div>
          <label for="contact_no" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
          <input
            type="tel"
            id="contact_no"
            name="contact_no"
            placeholder="Your Contact Number"
            required
            pattern="[0-9]{10}"
            title="Please enter a valid 10-digit phone number"
            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none transition"
          />
        </div>

        <div>
          <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
          <textarea
            id="message"
            name="message"
            placeholder="Your Message"
            rows="4"
            required
            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-purple-500 focus:outline-none transition resize-none"
          ></textarea>
        </div>

        <button
          type="submit"
          name="submit"
          class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-md py-4 text-lg transition transform hover:scale-105 shadow"
        >
          Send Message
        </button>
      </form>
      <div id="loader" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
  <div class="loader-spinner"></div>
</div>
  </main>

  <script>
    function toggleDropdown() {
      const menu = document.getElementById('dropdownMenu');
      menu.classList.toggle('hidden');
    }
    function handleSubmit(e) {
    e.preventDefault();  // 
   
    alert("Form Submittted ! We will contact you soon.");
 document.getElementById('loader').classList.remove('hidden');
    // 2 second baad home page pe redirect
    setTimeout(() => {
      window.location.href = "home.php";
    }, 2000);

    return false;  // Ensure form submit nahi hota reload ke saath
  }
    // Close dropdown on clicking outside
    window.addEventListener('click', function (e) {
      const menu = document.getElementById('dropdownMenu');
      const button = e.target.closest('button');
      if (!button && !menu.contains(e.target)) {
        menu.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
