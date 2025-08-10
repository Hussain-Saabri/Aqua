<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
<div class="min-h-screen flex items-center justify-center mt-5">
  <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
    <div class="text-center mt-5">
      <h1 class="text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text drop-shadow-lg">
        Aqua<span class="text-black">Leak</span>
      </h1>
    </div>

    <h2 class="text-3xl font-bold text-center text-blue-600 mb-4">Log In</h2>
   
    <?php if(count($errors) > 0): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php foreach($errors as $showerror) echo $showerror; ?>
      </div>
    <?php endif; ?>

    <form action="login-user.php" method="POST" autocomplete="">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="email">Email</label>
        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
               type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
      </div>

      <div class="mb-4 relative">
        <label class="block text-gray-700 mb-2" for="password">Password</label>
        <input id="password" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" 
               type="password" name="password" placeholder="Password" required>
        <span id="togglePassword" class="absolute right-3 top-10 cursor-pointer text-gray-500">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <div class="mb-4 text-right">
        <a href="forgot-password.php" class="text-blue-500 hover:underline text-sm">Forgot Password?</a>
      </div>

      <div class="mb-6">
        <input type="submit" name="login" value="Login" 
               class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 cursor-pointer">
      </div>

      <p class="text-center text-gray-600 text-sm">
        Not yet a member? <a href="signup-user.php" class="text-blue-500 hover:underline">Signup now</a>
      </p>
    </form>
  </div>
</div>

<script>
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.innerHTML = type === "password" 
        ? '<i class="fas fa-eye"></i>' 
        : '<i class="fas fa-eye-slash"></i>';
  });
</script>
</body>
</html>
