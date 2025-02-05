<?php
session_start();

if (!isset($_SESSION["ID_uzivatel"])) {
    header("location: ../prihlaseni.php");
    exit();
}

$ID_obrazky = $_GET["ID"];
$ID_autor = $_SESSION["ID_uzivatel"];

require_once 'database.php';
require_once 'functions.php';

if (emptyInputRemove($ID_obrazky, $ID_autor) !== false) {
    header('Location: ' . $_SERVER['HTTP_REFERER']. "?error=emptyinput");
    exit();
}

removePost($conn, $ID_obrazky, $ID_autor);
