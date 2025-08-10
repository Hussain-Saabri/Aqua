<?php
require 'connection.php';
session_start();


    if (isset($_POST['submit_feedback'])) {
        $complaint_id = $_GET['id'];
        $feedback_text = $_POST['feedback'];

        // Insert the feedback into the user_feedback table
        $sql = "INSERT INTO user_feedback (complaint_id, feedback_text) VALUES ('$complaint_id', '$feedback_text')";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Thanks You, Feedback Submitted Successfully');</script>";
        } else {
            // Handle the error if the insertion fails
            
            echo "<script>alert('You Have Already Submitted Feedback');</script>";
        }
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">
    <div class="container mx-auto">
        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Give Us Your Feedback</h1>

            <form method="POST" action="">
                <div class="mb-4">
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label><br>
                    <textarea id="feedback" name="feedback" rows="4" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-500"></textarea>
                </div>

                <div class="mb-4">
                    <button type="submit" name="submit_feedback" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="text-center mx-auto">
    <a href="home.php" class="rounded-lg bg-blue-500 text-white py-2 px-4">Go Back To Home</a>
</div>
</body>
</html>
