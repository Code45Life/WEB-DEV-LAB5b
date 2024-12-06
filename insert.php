<?php
include 'database.php';
include 'User.php';


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role'])) {
    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);

    // Register the user using POST data
    $result = $user->createUser($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role']);

    // Provide feedback to the user
    if ($result === true) {
        session_start();
        $_SESSION['user_id'] = $_POST['matric']; // or any other unique identifier

        // Redirect to a protected page (e.g., dashboard)
        header("Location: read.php");
        exit();
    } else {
        echo "Error: " . $result; // Output the error message from the method
    }

    // Close the database connection
    $db->close();
} else {
    echo "Invalid form submission. Please fill out all required fields.";
}
?>
