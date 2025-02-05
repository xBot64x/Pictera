<?php include_once 'header.php' ?>

<div class="vedle">
    <section class="nastaveni-sidebar">
        <ul>
            <li><a href="nastaveni.php?TAB=vzhled">Vzhled</a></li>
            <?php if (isset($_SESSION["ID_uzivatel"])) { ?>
                <li><a href="nastaveni.php?TAB=ucet">Účet</a></li>
                <li><a href="nastaveni.php?TAB=soukromi">Soukromí</a></li>
            <?php } ?>
        </ul>
    </section>

    <section class="nastaveni">
        <?php if (isset($_GET["TAB"])) {
            if ($_GET["TAB"] == "ucet") {
        ?>
                <p>účet</p><br>
                <a href="nastaveni.php?TAB=profilovyobrazek"><button>Profilový obrázek</button></a>
                <a href="nastaveni.php?TAB=uzivatelskejmeno"><button>Uživatelské jméno</button></a>
                <a href="nastaveni.php?TAB=heslo"><button>Heslo</button></a>
                <a href="nastaveni.php?TAB=email"><button>E-mail</button></a>
                <a class="dangerous" href="nastaveni.php?TAB=smazatucet">Smazat účet</a>

            <?php } else if ($_GET["TAB"] == "soukromi") { ?>
                <p>Soukromí</p><br>
                <label class="switch">
                    <input type="checkbox" name="privatni">
                    <span class="slider"></span>
                </label>
                <label for="privatni">Skrýt liky na svém profilu</label><br>
            <?php } else if ($_GET["TAB"] == "vzhled") { ?>
                <p>Vzhled stránky</p>
                <label for="darkmode">Tmavý režim</label><br>
                <label class="switch" name="darkmode">
                    <input id="darkModeToggle" type="checkbox" onclick="toggleDarkMode()">
                    <span class="slider"></span>
                </label>
            <?php } else if ($_GET["TAB"] == "profilovyobrazek") { ?>
                <p>Profilový obrázek</p><br>
                <form action="includes/setimage.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="obrazek" accept="image/png, image/jpeg, image/webp">
                    <button type="submit" name="submit">Uložit</button>
                </form>
                <form action="includes/removeimage.php" method="post" enctype="multipart/form-data">
                    <label for="obrazek">Odstranit profilový obrázek</label>
                    <button type="submit" name="submit">Odstranit</button>
                </form>
            <?php } else if ($_GET["TAB"] == "uzivatelskejmeno") { ?>
                <p>Změna uživatelského jméno</p><br>
                <form action="includes/changeUsernameScript.php" method="post">
                    <input type="text" name="novejmeno" placeholder="Nové uživatelské jméno">
                    <button type="submit" name="submit">Změnit</button>
                </form>
            <?php } else if ($_GET["TAB"] == "heslo") { ?>
                <p>Změna hesla</p><br>
                <form action="includes/changePasswordScript.php" method="post">
                    <input type="password" name="stareheslo" placeholder="Staré heslo">
                    <input type="password" name="noveheslo" placeholder="Nové heslo">
                    <input type="password" name="opakovani" placeholder="Potvrzení nového hesla">
                    <button type="submit" name="submit">Změnit</button>
                </form>
            <?php } else if ($_GET["TAB"] == "email") { ?>
                <p>Změna E-mailu</p><br>
                <form action="includes/changeEmailScript.php" method="post">
                    <input type="email" name="novyemail" placeholder="Nový e-mail">
                    <button type="submit" name="submit">Změnit</button>
                </form>
            <?php } else if ($_GET["TAB"] == "smazatucet") { ?>
                <p>smazat účet</p><br>
                <form action="includes/deleteaccountScript.php" method="post">
                    <button type="submit" name="submit" onclick="return confirm('Opravdu chcete smazat váš účet? (účet bude instantně smazán a s tím i vaše příspěvky, toto nejde vrátit!)')">Smazat účet</button>
                </form>
        <?php }
        } else if(isset($_GET["error"])){
            if ($_GET["error"] == "cantdeleteadmin") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Admin účty nelze odstranit! pokud opravdu chcete odstranit tento účet kontaktujte správce databáze.</p>";
            } else if ($_GET["error"] == "stmtfailed") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Nastala chyba, prosím zkuste to znovu.</p>";
            } else if ($_GET["error"] == "none") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Úspěch.</p>";
            } else if ($_GET["error"] == "nouser") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Uživatel s tímto jménem už existuje.</p>";
            } else if ($_GET["error"] == "emptyinput") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Prosím, vypňte všechna pole.</p>";
            } else if ($_GET["error"] == "nomatch") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Hesla se neschodují.</p>";
            } else if ($_GET["error"] == "wrongpassword") {
                echo "<br><p style=\"color:var(--accent1) !important;\">Nesprávné heslo.</p>";
            }
        }
        else {
            header("location: nastaveni.php?TAB=vzhled");
            exit();
        }
        ?>

        <!--
        <p>Vzhled stránky</p>
        <button onclick="toggleDarkMode()">Tmavý režim
        </button>
        <?php if (isset($_SESSION["ID_uzivatel"])) { ?>

            <p>Profil</p><br>
            <form action="includes/setimage.php" method="post" enctype="multipart/form-data">
                <label for="obrazek">Změnit profilový obrázek</label>
                <input type="file" name="obrazek" accept="image/png, image/jpeg, image/webp">
                <button type="submit" name="submit">Uložit</button>
            </form>
            <form action="includes/removeimage.php" method="post" enctype="multipart/form-data">
                <label for="obrazek">Odstranit profilový obrázek</label>
                <button type="submit" name="submit">Odstranit</button>
            </form>

            <p>smazat účet</p><br>
            <form action="includes/deleteaccountScript.php" method="post">
                <button type="submit" name="submit" onclick="return confirm('Opravdu chcete smazat váš účet? (účet bude instantně smazán a s tím i vaše příspěvky, toto nejde vrátit!)')">Smazat účet</button>
            </form>

            <p>soukromí</p><br>
            <label class="switch">
                <input type="checkbox" name="privatni">
                <span class="slider"></span>
            </label>
            <label for="privatni">privátní</label><br>
        -->

    <?php } ?>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "cantdeleteadmin") {
            echo "<br><p style=\"color:var(--accent1) !important;\">Admin účty nelze odstranit! pokud opravdu chcete odstranit tento účet kontaktujte správce databáze</p>";
        }
    }
    ?>
    </section>
</div>
<script src="http://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="js/nastaveni.js"></script>
<?php include_once 'footer.php' ?>