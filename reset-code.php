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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-md shadow-md w-96">
        <form action="reset-code.php" method="POST" autocomplete="off">
            <h2 class="text-center text-2xl font-bold mb-4">Code Verification</h2>

            <?php if(isset($_SESSION['info'])): ?>
                <div class="alert alert-success text-center py-2">
                    <?php echo $_SESSION['info']; ?>
                </div>
            <?php endif; ?>

            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger text-center mb-4">
                    <?php foreach($errors as $showerror): ?>
                        <?php echo $showerror; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <input class="w-full px-4 py-2 border rounded-md" type="number" name="otp" placeholder="Enter code" required>
            </div>

            <div class="mb-4">
                <input class="w-full px-4 py-2 bg-blue-500 text-white rounded-full cursor-pointer" type="submit" name="check-reset-otp" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
