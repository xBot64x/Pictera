<?php
session_start();

if (isset($_POST["submit"])) {
  $text = $_POST["text"];
  $misto = $_POST["misto"];
  $tagy = $_POST["tagy"];
  $ID_autor = $_SESSION["ID_uzivatel"];

  require_once 'database.php';
  require_once 'functions.php';

  if (emptyInputUploadText($text) !== false) {
    header("location: ../uploadtext.php?error=emptyinput");
    exit();
  }

  uploadText($conn, $text, $misto, $tagy, $ID_autor);

} else {
  header("location: ../upload.php");
  exit();
}
