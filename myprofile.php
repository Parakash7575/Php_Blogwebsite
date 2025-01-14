<?php

session_start();


include("Connection.php");


if (!isset($_SESSION['user_id'])) {
    
    header("Location: Login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$feedback = "";


$query = "SELECT post_id, title, content, likes FROM posts WHERE user_id = $1 ORDER BY created_at DESC";
$result = pg_prepare($conn, "fetch_posts", $query);
$result_execute = pg_execute($conn, "fetch_posts", [$user_id]);

if (!$result_execute) {
    $feedback = "<div style='text-align: center; color: red;'>Error fetching posts. Please try again later.</div>";
}


if (isset($_POST['like_post'])) {
    $post_id = $_POST['post_id'];
    $query_like = "UPDATE posts SET likes = likes + 1 WHERE post_id = $1";
    $result_like = pg_prepare($conn, "like_post", $query_like);
    $result_like_execute = pg_execute($conn, "like_post", [$post_id]);

    if ($result_like_execute) {
        $feedback = "<div style='text-align: center; color: green;'>Post liked successfully!</div>";
    } else {
        $feedback = "<div style='text-align: center; color: red;'>Error liking the post. Please try again.</div>";
    }
}


pg_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #333;
            color: white;
            margin-top: 2rem;
        }

        .post {
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .post p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .like-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .like-btn:hover {
            background-color: #45a049;
        }

        .likes-count {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>My Profile</h1>
        <p>Manage your account and settings</p>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="indexx.php">Home</a>
                </li>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Register.html">Sign up</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="myprofile.php">My Profile</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Create
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="Create.php">Create Post</a></li>
                            <li><a class="dropdown-item" href="update.php">Update Post</a></li>


                            <li><a class="dropdown-item" href="delete.php">Delete Post</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>


    <div class="container posts">
        <?php if (!empty($feedback)) echo $feedback; ?>
        <?php while ($row = pg_fetch_assoc($result_execute)) { ?>
            <div class="post">
                <h2><?php echo $row['title']; ?></h2>
                <p><?php echo $row['content']; ?></p>
                <form method="POST" action="">
                    <button type="submit" class="like-btn" name="like_post">Like</button>
                    <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                </form>
                <div class="likes-count"><?php echo $row['likes']; ?> Likes</div>
            </div>
        <?php } ?>
    </div>

    <footer>
        <p>&copy; 2025 My Blog. All Rights Reserved.</p>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
