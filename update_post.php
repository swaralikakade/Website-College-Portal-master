<?php
// Include necessary configuration
// Define database connection constants if not already defined
define('DB_USER', "root"); // db user
define('DB_PASSWORD', ""); // db password (mention your db password here)
define('DB_DATABASE', "CollegePortal"); // database name
define('DB_SERVER', "localhost"); // db server

$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE) or die("unable to connect");

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: a_login.php?activity=expired");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if post ID and other necessary data are provided
    if (!isset($_POST['post_id']) || !isset($_POST['title']) || !isset($_POST['description'])) {
        echo "Invalid request.";
        exit();
    }

    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Connect to the database
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Unable to connect");

    // Update the post in the database
    $sql = "UPDATE posts SET post_title = '$title', post_description = '$description' WHERE post_id = '$post_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: a_posts.php");
        exit();
    } else {
        echo "Error updating post: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
