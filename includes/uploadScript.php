<?php
session_start();

if (isset($_POST["submit"])) {
  $nazev = $_POST["nazev"];
  $popis = $_POST["popis"];
  $misto = $_POST["misto"];
  $tagy = $_POST["tagy"];
  $obrazek = $_FILES["obrazek"];
  $ID_autor = $_SESSION["ID_uzivatel"];

  if (isset($_POST["privatni"])) {
    $privatni = 1;
  } else {
    $privatni = 0;
  }

  if (isset($_POST["zakazatstahovani"])) {
    $stahovatelne = 0;
  } else {
    $stahovatelne = 1;
  }

  require_once 'database.php';
  require_once 'functions.php';

  if (emptyInputUpload($nazev, $obrazek) !== false) {
    header("location: ../upload.php?error=emptyinput");
    exit();
  }
  if (invalidFileType($obrazek) !== false) {
    header("location: ../upload.php?error=invalidfiletype");
    exit();
  }

  uploadImage($conn, $nazev, $popis, $misto, $tagy, $ID_autor, $obrazek, $privatni, $stahovatelne);

} else {
  header("location: ../upload.php");
  exit();
}
