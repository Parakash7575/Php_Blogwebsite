<?php

session_start();


include("Connection.php");


if (!isset($_SESSION['user_id'])) {
    
    header("Location: Login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$feedback = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    
    $title = htmlspecialchars(trim($_POST['title']));

    if (!empty($title)) {
        
        $query = "DELETE FROM posts WHERE user_id = $1 AND title = $2";

        
        $result = pg_prepare($conn, "delete_post", $query);

        if ($result) {
            
            $result_execute = pg_execute($conn, "delete_post", [$user_id, $title]);

            if ($result_execute) {
                
                $feedback = "<div style='text-align: center; color: green;'>Post deleted successfully!</div>";
            } else {
                
                $feedback = "<div style='text-align: center; color: red;'>Error deleting post. Please try again later.</div>";
            }
        } else {
            
            $feedback = "<div style='text-align: center; color: red;'>Error preparing statement. Please contact support.</div>";
        }
    } else {
        
        $feedback = "<div style='text-align: center; color: red;'>Title cannot be empty!</div>";
    }
}


pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Blog Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }
        .post-container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h2>Delete Post</h2>
        <?php if (!empty($feedback)) echo $feedback; ?>
        <form action="" method="post">
            <div class="input-group">
                <label for="title">Post Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <button type="submit" class="submit-btn" name="delete">Delete Post</button>
            <a href="myprofile.php" class="submit-btn" style="background-color: #28a745; text-align: center;">View Posts</a>
        </form>
    </div>
</body>
</html>
