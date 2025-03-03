<?php
session_start();

if (isset($_POST["submit"])) {
  $odkaz = $_POST["odkaz"];
  $nazev = $_POST["nazev"];
  $misto = $_POST["misto"];
  $ID_autor = $_SESSION["ID_uzivatel"];
  $privatni = (isset($_POST['privatni']) ? 1 : 0);

  require_once 'database.php';
  require_once 'functions.php';

  if (emptyInputUploadVideo($odkaz, $nazev) !== false) {
    header("location: ../nahratvideo.php?error=emptyinput");
    exit();
  }
  if (strpos($odkaz, 'youtube.com') === false && strpos($odkaz, 'youtu.be') === false) {
    header("location: ../nahratvideo.php?error=videoerror");
    exit();
  }
  
  uploadVideo($conn, $odkaz, $nazev, $misto, $privatni, $ID_autor);

} else {
  header("location: ../upload.php");
  exit();
}
