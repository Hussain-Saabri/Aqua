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
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-md shadow-md w-96">
        <form action="new-password.php" method="POST" autocomplete="off">
            <h2 class="text-2xl font-bold text-center mb-4">New Password</h2>

            <?php if(isset($_SESSION['info'])): ?>
                <div class="alert alert-success text-center mb-4">
                    <?php echo $_SESSION['info']; ?>
                </div>
            <?php endif; ?>

            <?php
            // Define $errors as an empty array to avoid undefined variable warning
            $errors = isset($errors) ? $errors : array();

            if(count($errors) > 0): ?>
                <div class="alert alert-danger text-center mb-4">
                    <?php foreach($errors as $showerror): ?>
                        <?php echo $showerror; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <input class="w-full px-4 py-2 border rounded-md" type="password" name="password" placeholder="Create new password" required>
            </div>

            <div class="mb-4">
                <input class="w-full px-4 py-2 border rounded-md" type="password" name="cpassword" placeholder="Confirm your password" required>
            </div>

            <div class="mb-4">
                <input class="w-full px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer" type="submit" name="change-password" value="Change">
            </div>
        </form>
    </div>
</div>

</body>
</html>
