<?php
session_start();

if (isset($_POST["submit"])) {
  $obrazek = $_FILES["obrazek"];
  $ID_uzivatel = $_SESSION["ID_uzivatel"];

  require_once 'database.php';
  require_once 'functions.php';

  if (empty($obrazek) === true) {
    header("location: ../nastaveni.php?error=emptyinput");
    exit();
  }

  setprofilepicture($conn, $obrazek, $ID_uzivatel);

} else {
  header("location: ../upload.php");
  exit();
}
