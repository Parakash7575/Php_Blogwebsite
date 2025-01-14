<?php

include("Connection.php");
include("Login.php");


$feedback = "";


$query = "
    SELECT posts.title, posts.content, posts.created_at, posts.likes, users.username 
    FROM posts 
    INNER JOIN users ON posts.user_id = users.user_id
    ORDER BY posts.created_at DESC
";
$result = pg_query($conn, $query);

if (!$result) {
    $feedback = "<div style='color: red;'>Error fetching posts. Please try again later.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        
        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2.5rem;
        }

        header p {
            font-size: 1.2rem;
            margin: 10px 0 0;
        }

        
        .navbar {
            margin-bottom: 20px;
        }

        
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }

        
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
            margin-top: 20px;
            text-align: center;
        }

        
        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to My Blog</h1>
        <p>Sharing thoughts, ideas, and stories</p>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="indexx.php">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="indexx.php">Home</a>
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
                            <a class="nav-link" href="myprofile.php">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Logout.php">Logout</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (!empty($feedback)) echo $feedback; ?>

        <div class="row">
            <?php
            
            while ($row = pg_fetch_assoc($result)) {
                echo '<div class="col-md-6 mb-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                echo '<h6 class="card-subtitle mb-2 text-muted">By: ' . htmlspecialchars($row['username']) . '</h6>';
                echo '<p class="card-text">' . htmlspecialchars($row['content']) . '</p>';
                echo '<p class="text-muted">Created on: ' . htmlspecialchars($row['created_at']) . '</p>';
                echo '<p><strong>Likes: </strong>' . htmlspecialchars($row['likes']) . '</p>';
                echo '<a href="#" class="btn btn-primary">Read more</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
