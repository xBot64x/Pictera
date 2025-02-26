<?php

if (isset($_POST["submit"])) {
    $jmeno = $_POST["uzivatelskejmeno"];
    $heslo = $_POST["heslo"];

    require_once 'database.php';
    require_once 'functions.php';

    if (emptyInputLogin($jmeno, $heslo) !== false) {
        header("location: ../prihlaseni.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $jmeno, $heslo);
}
else {
    header("location: ../prihlaseni.php");
    exit();
}