<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
    
    <!-- AquaLeak Logo -->
    <div class="text-center mb-6">
      <h1 class="text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text drop-shadow-lg">
        Aqua<span class="text-black">Leak</span>
      </h1>
    </div>

    <!-- Heading -->
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">Enter OTP Code</h2>

    <!-- Info Message -->
    <?php if(isset($_SESSION['info'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm text-center">
        <?php echo $_SESSION['info']; ?>
      </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(count($errors) > 0): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
        <?php foreach($errors as $showerror) echo $showerror; ?>
      </div>
    <?php endif; ?>

    <!-- OTP Form -->
    <form action="user-otp.php" method="POST" autocomplete="off">
      <div class="mb-5">
        <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center tracking-widest text-xl"
               type="number" name="otp" placeholder="Enter 6-digit OTP" required>
      </div>

      <div class="mb-4">
        <input type="submit" name="check" value="Verify Code"
               class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 cursor-pointer font-semibold">
      </div>
    </form>

    <!-- Footer Message -->
    <p class="text-center text-gray-500 text-sm">Didn't receive code? <a href="reset-code.php" class="text-blue-500 hover:underline">Resend</a></p>
  </div>
</div>

</body>
</html>
