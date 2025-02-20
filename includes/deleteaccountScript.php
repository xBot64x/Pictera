<?php
session_start();

if (isset($_POST["submit"])) {
    $ID_uzivatel = $_SESSION["ID_uzivatel"];

    require_once 'database.php';
    require_once 'functions.php';

    if(isset($_SESSION['admin'])){
        if($_GET["ID"] != $ID_uzivatel){
            deleteaccount($conn, $_GET["ID"], true);
            exit();
        }
        header("location: ../nastaveni.php?error=cantdeleteadmin");
        exit();
    }

    deleteaccount($conn, $ID_uzivatel, false);
}
else {
    header("location: ../index.php");
    exit();
}