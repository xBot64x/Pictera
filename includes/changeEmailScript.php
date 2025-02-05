<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_SESSION["ID_uzivatel"];
    $email = $_POST["novyemail"];

    if (empty($email)) {
        header("location: ../nastaveni.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../nastaveni.php?error=invalidemail");
        exit();
    }

    require_once 'database.php';
    require_once 'functions.php';

    changeusername($conn, $ID_uzivatel, $email);
}
else {
    header("location: ../index.php");
    exit();
}