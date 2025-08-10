<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>

</head>
<body class="bg-gray-100">

    
    <div class="min-h-screen flex items-center justify-center mt-5">
  <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
    <!-- Logo -->
    <div class="text-center mt-5">
      <h1 class="text-4xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-cyan-500 to-blue-400 text-transparent bg-clip-text drop-shadow-lg">
        Aqua<span class="text-black">Leak</span>
      </h1>
    </div>

    <!-- Heading -->
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-2 mt-4">Sign Up</h2>
    

    <!-- Error Handling -->
    <?php
      if(count($errors) == 1): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center text-sm">
          <?php foreach($errors as $showerror) echo $showerror; ?>
        </div>
    <?php elseif(count($errors) > 1): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
          <ul class="list-disc ml-5">
            <?php foreach($errors as $showerror): ?>
              <li><?php echo $showerror; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
    <?php endif; ?>

    <!-- Signup Form -->
    <form action="signup-user.php" method="POST" autocomplete="">
      <div class="mb-4">
        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
               type="text" name="name" placeholder="Full Name" required value="<?php echo $name ?>">
      </div>

      <div class="mb-4">
        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
               type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
      </div>

     <div class="relative mb-4">
  <input
    id="password"
    type="password"
    name="password"
    placeholder="Password"
    required
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
  />
  <span
    id="togglePassword"
    class="absolute right-3 top-2.5 cursor-pointer text-gray-500 hover:text-gray-700"
  >
    <i class="fa-solid fa-eye"></i>
  </span>
</div>

 <div class="relative mb-4">
  <input
    id="password"
    type="password"
    name="cpassword"
    placeholder="Confirm Password"
    required
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
  />
  <span
    id="togglePassword"
    class="absolute right-3 top-2.5 cursor-pointer text-gray-500 hover:text-gray-700"
  >
    <i class="fa-solid fa-eye"></i>
  </span>
</div>


              

      <div class="mb-6">
        <input type="submit" name="signup" value="Signup" 
               class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 cursor-pointer">
      </div>







      

      <p class="text-center text-gray-600 text-sm">
        Already a member? <a href="login-user.php" class="text-blue-500 hover:underline">Login here</a>
      </p>
    </form>
  </div>
</div>

</body>
</html>
<script>

const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", () => {
  // Toggle input type
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);

  // Toggle icon
  const icon = togglePassword.querySelector("i");
  icon.classList.toggle("fa-eye");
  icon.classList.toggle("fa-eye-slash");
});


</script>
