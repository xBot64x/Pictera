<?php
session_start();

if (isset($_GET["ID_obrazek"])) {
    $ID_obrazek = $_GET["ID_obrazek"];
    $ID_uzivatel = $_SESSION["ID_uzivatel"];

    require_once 'database.php';
    require_once 'functions.php';

    likePost($conn, $ID_obrazek, $ID_uzivatel);
}
else {
    header("location: ../feed.php");
    exit();
}