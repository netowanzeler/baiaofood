<?php

//main connection file for both admin & front end
$servername = "212.85.3.19"; //server
$username = "u468421729_netowanzeler"; //username
$password = "4>iP!]#dT]zU"; //password
$dbname = "u468421729_baiaofood";  //database

// Create connection
$db = mysqli_connect($servername, $username, $password, $dbname); // connecting 
// Check connection
if (!$db) {       //checking connection to DB	
    die("Connection failed: " . mysqli_connect_error());
}

?>
