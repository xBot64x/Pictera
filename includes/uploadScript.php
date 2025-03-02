<?php
session_start();

if (isset($_POST["submit"])) {
  $nazev = $_POST["nazev"];
  $popis = $_POST["popis"];
  $misto = $_POST["misto"];
  $obrazek = $_FILES["obrazek"];
  $ID_autor = $_SESSION["ID_uzivatel"];
  $privatni = (isset($_POST['privatni']) ? 1 : 0);
  $stahovatelne = (isset($_POST['zakazatstahovani']) ? 0 : 1);

  require_once 'database.php';
  require_once 'functions.php';

  if (emptyInputUpload($nazev, $obrazek) !== false) {
    header("location: ../nahratobrazek.php?error=emptyinput");
    exit();
  }
  if (invalidFileType($obrazek) !== false) {
    header("location: ../nahratobrazek.php?error=invalidfiletype");
    exit();
  }

  uploadImage($conn, $nazev, $popis, $misto, $ID_autor, $obrazek, $privatni, $stahovatelne);

} else {
  header("location: ../nahratobrazek.php");
  exit();
}
