<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_SESSION["ID_uzivatel"];
    $stareheslo = $_POST["stareheslo"];
    $heslo = $_POST["noveheslo"];
    $opakovani = $_POST["opakovani"];

    if (empty($stareheslo) || empty($heslo) || empty($opakovani)) {
        header("location: ../nastaveni.php?error=emptyinput");
        exit();
    }
    else if ($heslo !== $opakovani) {
        header("location: ../nastaveni.php?error=nomatch");
        exit();
    }

    require_once 'database.php';
    require_once 'functions.php';

    changepassword($conn, $ID_uzivatel, $heslo, $stareheslo);
}
else {
    header("location: ../index.php");
    exit();
}