<?php
$servername = "178.128.206.30";
$username = "dev_tatevik";
$password = "E~iS=?A0bls517n@JiWbTINcEcbGgP9j";
$dbname = "leadbase";

// Create connection to DB
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
   
?>