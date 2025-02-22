<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_POST["ID"];
    $heslo = $_POST["noveheslo"];

    if (empty($heslo)) {
        header("location: ../admin.php?TAB=uzivatele&error=emptyinput");
        exit();
    }

    require_once 'database.php';
    require_once 'functions.php';

    changepasswordadmin($conn, $ID_uzivatel, $heslo);
}
else {
    header("location: ../index.php");
    exit();
}