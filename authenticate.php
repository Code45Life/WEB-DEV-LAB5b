<?php

include 'Database.php';
include 'User.php';


if (isset($_POST['submit']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Sanitize inputs using mysqli_real_escape_string
    $matric = $db->real_escape_string($_POST['matric']);
    $password = $db->real_escape_string($_POST['password']);

    // Validate inputs
    if (!empty($matric) && !empty($password)) {
        $user = new User($db);
        $userDetails = $user->getUser($matric);

        // Check if user exists and verify password
        if ($userDetails && password_verify($password, $userDetails['password'])) {
            session_start();
            // Set the session variable
            $_SESSION['user_id'] = $userDetails['matric']; // Store matric or user ID

            // Redirect to read.php on successful authentication
            header("Location: read.php");
            exit();
        } else {
        // Handle login failure
        echo 'Invalid username or password. Please <a href="login.html">login</a> again.';
        }
    }
}