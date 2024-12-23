<?php
$servername = "localhost"; // MySQL server address
$username = "root"; // MySQL username (default is 'root' on local)
$password = ""; // MySQL password (default is empty for 'root' user on local)
$dbname = "cms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
