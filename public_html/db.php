<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$hostname = 'localhost';
$dbname = 'sline';
$username = 'qweroot';
$password = 'rootroot';
// Create connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$conn) {
  http_response_code(500);
  die("Connection failed: " . mysqli_connect_error());
}

// Check for connection error
if ($conn->connect_error) {
  http_response_code(500);
  die("Connection failed: " . $conn->connect_error);
}
?>
