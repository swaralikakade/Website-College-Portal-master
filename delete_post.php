<?php
// Include necessary configuration and start session
define('DB_USER', "root"); // db user
define('DB_PASSWORD', ""); // db password (mention your db password here)
define('DB_DATABASE', "CollegePortal"); // database name
define('DB_SERVER', "localhost"); // db server

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Unable to connect");

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: a_login.php?activity=expired");
    exit();
}

// Check if post title is provided
if (!isset($_POST['post_title'])) {
    echo "Post title not provided.";
    exit();
}

$post_title = $_POST['post_title'];

// Delete post by post title
$sql = "DELETE FROM posts WHERE post_title = '$post_title'";
if (mysqli_query($conn, $sql)) {
    echo "Post deleted successfully.";
} else {
    echo "Error deleting post: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
