<?php require_once "controllerUserData.php"; ?>
<?php
if ($_SESSION['info'] == false) {
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class=" text-white">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="w-full max-w-md">
            <?php
            if (isset($_SESSION['info'])) {
                ?>
                <div class="bg-green-500 text-white text-center py-2 mb-4">
                    <?php echo $_SESSION['info']; ?>
                </div>
                <?php
            }
            ?>
            <form action="login-user.php" method="POST">
                <div class="mb-4">
                    <input class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded-full w-full cursor-pointer" type="submit" name="login-now" value="Login Now">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
