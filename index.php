<?php
session_start();

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // Agar session me email hai, toh home.php redirect karo
    header('Location: home.php');
    exit;
} else {
    // Agar email session me nahi hai, toh login page bhejo
    header('Location: login-user.php');
    exit;
}
?>
