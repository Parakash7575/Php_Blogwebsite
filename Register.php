<?php
include("Connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $query = "SELECT * FROM users WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));

    if (pg_num_rows($result) > 0) {
        $errorMessage = "Username already exists. Please try a different one.";
        header("Location: register.html?error=" . urlencode($errorMessage));
        exit();
    }

    
    $query = "INSERT INTO users (username, email, password) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, array($username, $email, $password));

    if ($result) {
        header("Location: Login.html");
        exit();
    } else {
        $errorMessage = "Registration failed. Please try again.";
        header("Location: register.html?error=" . urlencode($errorMessage));
        exit();
    }
}
?>
