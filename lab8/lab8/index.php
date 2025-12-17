<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/SaltList.php');
require_once('./app/PurposeList.php');
require_once('./app/TypeList.php');
require_once('./app/PropertyList.php');
$servername = "localhost";
$username = "root";
$password = "";
$database ='salt_db';
$a=new TypeList();
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM types";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $a->add($row);
  }
  $a->display();
} else {
  echo "0 results";
}
$conn->close();