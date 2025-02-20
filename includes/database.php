<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "knizef_obrazky";



$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Připojení selhalo: " . mysqli_connect_error());
}
