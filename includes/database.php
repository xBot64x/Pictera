<?php

$servername = "localhost";
$username = "knizef";
$password = "FTp123";
$dbname = "knizef_obrazky";



$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Připojení selhalo: " . mysqli_connect_error());
}
