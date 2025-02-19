<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_SESSION["ID_uzivatel"];
    $jmeno = $_POST["novejmeno"];

    if (empty($jmeno)) {
        header("location: ../nastaveni.php?error=emptyinput");
        exit();
    }

    require_once 'database.php';
    require_once 'functions.php';

    changeusername($conn, $ID_uzivatel, $jmeno);
}
else {
    header("location: ../index.php");
    exit();
}