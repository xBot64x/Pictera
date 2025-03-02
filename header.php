<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs" data-theme="light">

<head>
    <title>Pictera - přidejde se</title>
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Pictera" />
    <link rel="manifest" href="/favicon/site.webmanifest" />
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/nav.css?v=2">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin.css">
    <script type="text/javascript" src="js/darkmode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="main">
        <nav class="header">
            <?php
            if (isset($_SESSION["uzivatelskejmeno"])) {
                echo '<a href="feed.php" class="logo">Pictera</a>';
            } else {
                echo '<a href="index.php" class="logo">Pictera</a>';
            }
            ?>
            <span class="squiggle">
                <svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170 7">
                    <path d="M1 3.5C5 0.166667 9 0.166667 13 3.5C17 6.83333 21 6.83333 25 3.5C29 0.166667 33 0.166667 37 3.5C41 6.83333 45 6.83333 49 3.5C53 0.166667 57 0.166667 61 3.5C65 6.83333 69 6.83333 73 3.5C77 0.166667 81 0.166667 85 3.5C89 6.83333 93 6.83333 97 3.5C101 0.166667 105 0.166667 109 3.5C113 6.83333 117 6.83333 121 3.5C125 0.166667 129 0.166667 133 3.5C137 6.83333 141 6.83333 145 3.5C149 0.166667 153 0.166667 157 3.5C161 6.83333 165 6.83333 169 3.5" stroke="currentColor" stroke-width="2" />
                </svg>
            </span>

            <div class="header-right">
                <?php
                if (isset($_SESSION["admin"])) {
                    echo '<a class="navbutton" href="admin.php?TAB=uzivatele">Tabulka uživatelů</a>';
                    echo '<a class="navbutton" href="admin.php?TAB=posty">Tabulka postů</a>';
                }
                if (isset($_SESSION["uzivatelskejmeno"])) {
                    echo '<a class="navbutton" href="nahrat.php">Nahrát</a>';
                    echo '<div class="dropdown">';
                    echo '<a onclick="showHeaderDropdown()" class="navimage"><img src="profiles/' . $_SESSION["profilovyobrazek"] . '.webp"></a>';
                    echo '<div class="dropdown-content" id="headerDropdown">';
                    if (isset($_SESSION["admin"])) {
                        echo '<a class="mobile" href="admin.php?TAB=uzivatele">Tabulka uživatelů</a>';
                        echo '<a class="mobile" href="admin.php?TAB=posty">Tabulka postů</a>';
                    }
                    echo '<a class="mobile" href="nahrat.php">Nahrát</a>';
                    echo '<a class="mobile" href="feed.php">Pro tebe</a>';
                    echo '<a class="mobile" href="feed.php?Order=cas">Nové</a>';
                    echo '<a class="mobile" href="kontakt.php">Kontakt</a>';
                    echo '<a class="mobile" href="podporit.php">Podpořit</a><hr>';
                    echo '<a href="profil.php?ID=' . $_SESSION["uzivatelskejmeno"] . '">' . $_SESSION["uzivatelskejmeno"] . '</a>';
                    echo '<a href="nastaveni.php">Nastavení</a>';
                    echo '<a href="includes/logout.php">Odhlásit se</a>';
                    echo '</div>';
                    echo '</>';
                } else {
                    echo '<a class="navbutton" href="nastaveni.php">Nastavení</a>';
                    echo '<a class="navbutton" href="registrace.php">registrace</a>';
                    echo '<a class="navbutton" href="prihlaseni.php" style="color: var(--accent1)">přihlásit se</a>';
                    echo '<a class="navbutton mobile" href="prihlaseni.php" style="color: var(--accent1)">přihlásit se</a>';
                    echo '<div class="dropdown mobile">';
                    echo '<a onclick="showHeaderDropdown()" class="navimage"><svg xmlns="http://www.w3.org/2000/svg" height="52px" viewBox="0 -960 960 960" width="52px" fill="#e3e3e3"><path d="M150-240q-12.75 0-21.37-8.68-8.63-8.67-8.63-21.5 0-12.82 8.63-21.32 8.62-8.5 21.37-8.5h660q12.75 0 21.38 8.68 8.62 8.67 8.62 21.5 0 12.82-8.62 21.32-8.63 8.5-21.38 8.5H150Zm0-210q-12.75 0-21.37-8.68-8.63-8.67-8.63-21.5 0-12.82 8.63-21.32 8.62-8.5 21.37-8.5h660q12.75 0 21.38 8.68 8.62 8.67 8.62 21.5 0 12.82-8.62 21.32-8.63 8.5-21.38 8.5H150Zm0-210q-12.75 0-21.37-8.68-8.63-8.67-8.63-21.5 0-12.82 8.63-21.32 8.62-8.5 21.37-8.5h660q12.75 0 21.38 8.68 8.62 8.67 8.62 21.5 0 12.82-8.62 21.32-8.63 8.5-21.38 8.5H150Z"/></svg></a>';
                    echo '<div class="dropdown-content" id="headerDropdown">';
                    echo '<a href="nastaveni.php">Nastavení</a>';
                    echo '<a href="registrace.php">registrace</a>';
                    echo '<a href="prihlaseni.php">přihlásit se</a>';
                    echo '</div>';
                    echo '</>';
                }
                ?>
            </div>
        </nav>
        <?php
        if (isset($_SESSION["ID_uzivatel"])) {
            if (!file_exists('profiles/' . $_SESSION["ID_uzivatel"] . '.webp') && basename($_SERVER['PHP_SELF']) != 'nastaveni.php' && !isset($_COOKIE["hidepopup"])) {
                echo '<a href="nastaveni.php?TAB=profilovyobrazek">';
                echo '<div id="notification">';
                echo '<span>Dokončete svůj profil přidáním profilového obrázku</span>';
                echo '<a onclick="hidepopup()">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M256-227.69 227.69-256l224-224-224-224L256-732.31l224 224 224-224L732.31-704l-224 224 224 224L704-227.69l-224-224-224 224Z"/></svg>';
                echo '</a>';
                echo '</div>';
                echo '</a>';
            };
            
        };
        ?>