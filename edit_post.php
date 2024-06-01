<?php
// Include necessary configuration and start session
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

// Check if post ID is provided in the URL
if (!isset($_GET['post_id'])) {
    echo "Post ID not provided.";
    exit();
}

$post_id = $_GET['post_id'];

// Connect to the database
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Unable to connect");

// Fetch post details from the database based on post ID
$sql = "SELECT post_id, post_title, post_description FROM posts WHERE post_id = '$post_id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Post not found.";
    exit();
}

// Fetch post details
$row = mysqli_fetch_assoc($result);
$title = $row["post_title"];
$description = $row["post_description"];

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
    <!-- Include any necessary stylesheets or scripts -->
</head>
<body>
    <h1>Edit Post</h1>
    <form action="update_post.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>"><br><br>
        <label for="description">Description:</label>
        <textarea name="description"><?php echo $description; ?></textarea><br><br>
        <button type="submit">Update Post</button>
    </form>
</body>
</html>
