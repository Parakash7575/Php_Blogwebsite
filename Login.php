<?php

include("Connection.php");


session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query = "SELECT user_id, password FROM users WHERE username = $1";

    
    $prepared = pg_prepare($conn, "login_query", $query);

    if ($prepared) {
        
        $result = pg_execute($conn, "login_query", array($username));

        
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);

            if ($password === $row['password']) { 
                
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id']; 

                
                header("Location: indexx.php");
                exit();
            } else {
                
                header("Location: Login.html?error=Invalid%20username%20or%20password");
                exit();
            }
        } else {
            
            header("Location: Login.html?error=Invalid%20username%20or%20password");
            exit();
        }
    } else {
        echo "Error preparing statement: " . pg_last_error($conn);
    }

    pg_close($conn);
}
?>
