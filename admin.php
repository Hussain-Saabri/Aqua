<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">

<?php
session_start();

$username = "admin";
$password = "Hussain@72";

if (isset($_SESSION['username'])) {
?>
  <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md flex items-center justify-between px-6 md:px-16 h-16">
    <a href="admin.php" class="text-3xl md:text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text">
      Aqua<span class="text-black">Leak</span>
    </a>

    <nav class="flex items-center space-x-6">
    
      <a href="admin.html" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition duration-300 shadow font-medium">Logout</a>
    </nav>
  </header>

  <div class="container mx-auto h-screen flex flex-col justify-center items-center pt-20">
    <h1 class="text-4xl font-bold text-black">Welcome admin !!</h1>
    <div class="view mt-8 text-center">
      <a href="admin-data.php" class="text-xl font-bold text-white bg-blue-600 py-4 px-16 rounded-full hover:text-gray-600 hover:bg-blue-500 transition">
        Complaints
      </a>
    </div>
  </div>

<?php
} else {
    if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']==$username && $_POST['password']==$password){

        $_SESSION['username']=$username;
        ?>
        <script>
            alert('Successfully logged in!')
            window.location.href = "admin.php"; // redirect to avoid re-submission
        </script>
        <?php
    }
    else{
        ?>
        <script>
            alert('The Username/Password entered by you is incorrect. Please Try Again!!!')
            window.location.href = "login.php"; // redirect to login or wherever
        </script>
        <?php
    }
}
?>

</body>
</html>
