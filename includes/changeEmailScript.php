<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_SESSION["ID_uzivatel"];
    $email = $_POST["novyemail"];

    require_once 'database.php';
    require_once 'functions.php';

    if (empty($email)) {
        header("location: ../nastaveni.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../nastaveni.php?error=invalidemail");
        exit();
    }
    if (usernameExists($conn, $email, $email) !== false) {
        header("location: ../nastaveni.php?error=noemail");
        exit();
    }

    changeemail($conn, $ID_uzivatel, $email);
}
else {
    header("location: ../index.php");
    exit();
}