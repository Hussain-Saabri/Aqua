<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (make sure to include your database configuration)
    require_once "connection.php";

    // Retrieve form data and sanitize inputs
    $name = mysqli_real_escape_string($con, $_POST["name"]); // Use "name1" from your form
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $phone = mysqli_real_escape_string($con, $_POST["phone"]);
    $address = mysqli_real_escape_string($con, $_POST["address"]);
    $location = mysqli_real_escape_string($con, $_POST["location"]);
    $file=FILES('photo');
    print_($file);
    // SQL query to insert data into the database
    $insert_query = "INSERT INTO report (name, email, phone, address, location) 
                    VALUES ('$name', '$email', '$phone', '$address', '$location')";

    // Execute the SQL query
    if (mysqli_query($con, $insert_query)) {
        // Data has been successfully inserted
        echo "Data has been successfully inserted into the database.";
    } else {
        // Error occurred while inserting data
        echo "Error: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
