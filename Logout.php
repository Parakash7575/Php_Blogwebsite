<?php
include("Login.php");


session_unset();


session_destroy();


header("Location: indexx.php");
exit;
?>
