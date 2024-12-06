<?php
include 'Database.php';
include 'User.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the POST request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);
    $user->deleteUser($matric);

    // Close the connection
    $db->close();
}