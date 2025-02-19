<?php
session_start();

$ID_uzivatel = $_SESSION["ID_uzivatel"];
$privatni = (isset($_POST['privatni']) ? 1 : 0);

if (empty($ID_uzivatel)) {
    header("location: ../nastaveni.php?error=emptyinput");
    exit();
}

require_once 'database.php';
require_once 'functions.php';

hideLikes($conn, $ID_uzivatel, $privatni);
