<?php

session_start();
include("Connection.php");
$user_id = $_SESSION['user_id'];
$feedback = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));

    if (!empty($title) && !empty($content)) {
        
        $query = "INSERT INTO posts (user_id, title, content, created_at) VALUES ($1, $2, $3, NOW())";

        
        $result = pg_prepare($conn, "insert_post", $query);

        if ($result) {
            
            $result_execute = pg_execute($conn, "insert_post", [$user_id, $title, $content]);

            if ($result_execute) {
                
                $feedback = "<div style='text-align: center; color: green;'>Post created successfully!</div>";
            } else {
                
                $feedback = "<div style='text-align: center; color: red;'>Error inserting data. Please try again later.</div>";
            }
        } else {
            
            $feedback = "<div style='text-align: center; color: red;'>Error preparing statement. Please contact support.</div>";
        }
    } else {
        
        $feedback = "<div style='text-align: center; color: red;'>All fields are required!</div>";
    }
}
pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Blog Post</title>
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
        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 900px;
        }
        .post-container {
            width: 60%;
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
        .input-group input, .input-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-btn, .view-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .submit-btn:hover, .view-btn:hover {
            background-color: #0056b3;
        }
        .view-btn {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-container">
            <h2>Create New Post</h2>
            <?php if (!empty($feedback)) echo $feedback; ?>
            <form action="" method="post">
                <div class="input-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="input-group">
                    <label for="content">Post Content</label>
                    <textarea id="content" name="content" rows="5" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Create Post</button>
            </form>
        </div>
     <div class="view-container">
            <a href="myprofile.php" class="view-btn">View My Posts</a>
        </div>
    </div>
</body>
</html>
