<?php

define('DB_USER', "root"); // db user
define('DB_PASSWORD', ""); // db password (mention your db password here)
define('DB_DATABASE', "CollegePortal"); // database name
define('DB_SERVER', "localhost"); // db server

session_start();

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Unable to connect");

if (!isset($_SESSION['id'])) {
    header("Location: a_login.php?activity=expired");
    exit();
}

// Fetch posts from the database
$sql = "SELECT post_id, post_title, post_description FROM posts ORDER BY post_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>College Portal</title>
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/home.css">
    <style>
        .delete-btn, .edit-btn {
            background-color: #CD5E9B;
            color: black;
            padding: 10px 20px;
            font-family: 'Slabo 27px', serif;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            border-radius: 18px;
            cursor: pointer;
            opacity: 0.8;
            margin-left: 10px;
        }

        .delete-btn, .edit-btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <nav>
        <img id="logo" src="src\meswcoe.jpeg" alt="">
        <ul>
            <li id="navbar">
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="box">
        <ul class="dashboard">
            <div class="profile">
                <img id="profile" src="src\profile.png" alt="">
                <a style="font-size: 25px" href="#"><?php echo $_SESSION["uname"] ?></a>
            </div>
            <hr>
            <div class="leftbox">    
                <li id="left-box"><a href="a_home.php">Home</a></li>
                <li id="left-box"><a href="a_posts.php" style="color: white">Posts</a></li>
            </div> 
        </ul>

        <div class="box2">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="post-container">
                        <label class="post">
                            <b><?php echo $row["post_title"]; ?></b>
                        </label>
                        <br>
                        <label class="post">
                            <p style="white-space:pre-wrap"><?php echo $row["post_description"]; ?></p>
                        </label>

                        <!-- Edit button -->
                        <a href="edit_post.php?post_id=<?php echo $row["post_id"]; ?>" class="edit-btn">Edit</a>

                        <!-- Delete button -->
                        <form action="delete_post.php" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $row["post_id"]; ?>">
                            <input type="hidden" name="post_title" value="<?php echo $row["post_title"]; ?>">
                            <input type="submit" value="Delete" class="delete-btn">
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "No posts found.";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <button class="open-btn" onclick="openForm()" id="add-post">Add Post</button>
    
    <div class="form-popup" id="myForm">
        <form action="addpost.php" class="form-container" method="POST">
            <h1>POST DETAILS</h1>
            <label for="title"><b>Title:</b></label>
            <input type="text" placeholder="Enter Post Title" name="title" required>
            <label for="description"><b>Description:</b></label>
            <textarea type="text" style="white-space: pre-wrap" placeholder="Enter Post Description" name="description" required></textarea>
            <button type="submit" class="btn">Post</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
        </form>
    </div>

    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "flex";
            document.getElementById("add-post").style.display = "none";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
            document.getElementById("add-post").style.display = "flex";
        }
    </script>
</body>
</html>
