<?php
include_once 'header.php';
include_once 'sidebar.php';
?>
<section class="admin">
    <?php

    if (!isset($_SESSION["admin"])) {
        header("location: /prihlaseni.php");
        exit();
    }

    require_once 'includes/database.php';
    require_once 'includes/functions.php';

    if ($_GET["TAB"] == "uzivatele") {
        $sql = "SELECT * FROM uzivatele";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Uživatelské jméno</th><th>Email</th><th>Skrýt liky</th><th>Náhled</th><th>Změnit heslo</th><th>Smazat</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["ID_uzivatel"] . "</td>";
                echo "<td><a href='profil.php?ID=". $row["uzivatelskejmeno"] ." '>" . $row["uzivatelskejmeno"] . "</a></td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . ($row["skryt_liky"] ? "Ano" : "Ne") . "</td>";
                echo "<td><img src='profiles/" . $row["profilovyobrazek"] . ".webp' alt='" . $row["uzivatelskejmeno"] . "' style='width: 50px; height: auto;'></td>";
                echo "<td style='width:30px'><form action='includes/changePasswordAdminScript.php' method='POST'>
            <input name='noveheslo' placeholder='heslo' required>

            <button type='submit' name='submit'>Změnit heslo</button>
          </form></td>";
                echo "<td style='width:30px'><form action='includes/deleteaccountScript.php' method='POST'>
            <input type='hidden' name='ID' value='" . $row["ID_uzivatel"] . "'>
            <button type='submit' name='submit'>Smazat</button>
          </form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Žádní uživatelé nenalezeni.";
        }
    } else {
        $sql = "SELECT obrazky.*, uzivatele.uzivatelskejmeno FROM obrazky 
    JOIN uzivatele ON obrazky.ID_autor = uzivatele.ID_uzivatel";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Název</th><th>Popis</th><th>Autor</th><th>Soukromé</th><th>Náhled</th><th>Akce</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["ID_obrazky"] . "</td>";
                echo "<td style='width:150px'>" . $row["nazev"] . "</td>";
                echo "<td>" . $row["popis"] . "</td>";
                echo "<td>" . $row["uzivatelskejmeno"] . "</td>";
                echo "<td>" . ($row["privatni"] ? "Ano" : "Ne") . "</td>";
                echo "<td><img src='uploads/" . $row["ID_obrazky"] . ".webp' alt='" . $row["nazev"] . "' style='width: 50px; height: auto;'></td>";
                echo "<td style='width:30px'><form action='includes/removeScript.php' method='GET'>
            <input type='hidden' name='ID' value='" . $row["ID_obrazky"] . "'>
            <button type='submit'>Smazat</button>
          </form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Žádné příspěvky nenalezeny.";
        }
    }
    mysqli_close($conn);
    ?>
</section>