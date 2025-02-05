<?php

if (isset($_POST["submit"])) {
    $email = $_POST["e-mail"];
    $uzivatelskejmeno = $_POST["uzivatelske_jmeno"];
    $heslo = $_POST["heslo"];
    $heslo_opakovani = $_POST["heslo_opakovani"];

    require_once 'database.php';
    require_once 'functions.php';

    if (emptyInputSignup($email, $uzivatelskejmeno, $heslo, $heslo_opakovani) !== false) {
        header("location: ../registrace.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($uzivatelskejmeno) !== false) {
        header("location: ../registrace.php?error=invalidusername");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../registrace.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($heslo, $heslo_opakovani) !== false) {
        header("location: ../registrace.php?error=passwordsdontmatch");
        exit();
    }
    if (usernameExists($conn, $uzivatelskejmeno, $email) !== false) {
        header("location: ../registrace.php?error=usernametaken");
        exit();
    }

    createUser($conn, $email, $heslo, $uzivatelskejmeno);

}
else {
    header("location: ../registrace.php");
    exit();
}