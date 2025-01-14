
<?php

$host ="localhost" ;
$dbname = "Blogg_db";
$user = "postgres";
$password = "0707";


$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");


if (!$conn) {
    die("An error occurred while connecting to the database.");
}

?>
