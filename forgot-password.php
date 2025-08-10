<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="forgot-password.php" method="POST" autocomplete="">
                <h2 class="text-2xl text-center font-semibold mb-4">Forgot Password</h2>
                <p class="text-center mb-4">Enter your email address</p>
                <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center mb-4">
                            <?php 
                                foreach($errors as $error){
                                    echo $error;
                                }
                            ?>
                        </div>
                        <?php
                    }
                ?>
                <div class="mb-4">
                    <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email ?>">
                </div>
                <div class="mb-4">
                    <input class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full w-full cursor-pointer" type="submit" name="check-email" value="Continue">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
