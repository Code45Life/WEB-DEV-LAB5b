<?php
include 'Database.php';
include 'User.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    if (empty($matric)) {
        die("Matric value is required.");
    }

    // Initialize database and fetch user details
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userDetails = $user->getUser($matric);

    $db->close();

    if (!$userDetails) {
        die("User not found.");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update User</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <h1>Update User</h1>
        <form action="update.php" method="post">
            <label for="matric">Matric</label>
            <input type="text" id="matric" name="matric" value="<?php echo $userDetails['matric']; ?>" ><br>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $userDetails['name']; ?>"><br>
            <label for="role">Access Level</label>
            <select name="role" id="role" required>
                <option value="">Please select</option>
                <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
                <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
            </select><br>
            <input type="submit" value="Update">
            <a href="read.php">Cancel</a>
        </form>
    </body>

    </html>
    <?php
} else {
    echo "Invalid request.";
}
?>
