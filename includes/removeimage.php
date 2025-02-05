<?php
session_start();

if (isset($_POST["submit"])) {
  $ID_uzivatel = $_SESSION["ID_uzivatel"];

  require_once 'database.php';
  require_once 'functions.php';

  removeprofilepicture($conn, $ID_uzivatel);

} else {
  header("location: ../upload.php");
  exit();
}
