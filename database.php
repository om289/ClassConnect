<?php

// Database connection configuration
$server = "localhost";
$user = "root";
$passdb = "";
$db = "cc_db";

// Connect to the CC database or terminate with error
$connect = mysqli_connect( $server, $user, $passdb, $db )or die( "Connection Error" );

?>
