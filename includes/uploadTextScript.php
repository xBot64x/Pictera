<?php
session_start();

if (isset($_POST["submit"])) {
  $text = $_POST["text"];
  $misto = $_POST["misto"];
  $ID_autor = $_SESSION["ID_uzivatel"];
  $privatni = (isset($_POST['privatni']) ? 1 : 0);

  require_once 'database.php';
  require_once 'functions.php';

  if (emptyInputUploadText($text) !== false) {
    header("location: ../nahrattext.php?error=emptyinput");
    exit();
  }

  uploadText($conn, $text, $misto, $privatni, $ID_autor);

} else {
  header("location: ../upload.php");
  exit();
}
