<?php
include_once 'header.php';
include_once 'sidebar.php';
include_once 'includes/database.php';

// Check if ID parameter is set
if (isset($_GET["ID"])) {
    $userID = $_GET["ID"];
    if(isset($_GET["TAB"])){
        $tab = $_GET["TAB"];
    }
    else{
        $tab = "posty";
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM uzivatele WHERE uzivatelskejmeno = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    // Bind the parameter and execute the statement
    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);

    // Get the result
    $resultData = mysqli_stmt_get_result($stmt);

    // Check if user exists
    if ($row = mysqli_fetch_assoc($resultData)) {
        $uzivatelskejmeno = $row['uzivatelskejmeno'];
        $ID_uzivatel = $row['ID_uzivatel'];
        $profilovyobrazek = $row['profilovyobrazek'];
        $skryt_liky = $row['skryt_liky'];
    } else {
        echo '<p class="nopost">Uživatel neexistuje</p>';
        include_once 'footer.php';
        exit();
    }

    mysqli_stmt_close($stmt);
} 
else {
    echo '<p class="nopost">Uživatel neexistuje</p>';
    include_once 'footer.php';
    exit();
}
?>

<section class="profile">
    <div class="profile-header">
        <img src="profiles/<?php echo htmlspecialchars($profilovyobrazek); ?>.webp">
        <h2><?php echo htmlspecialchars($uzivatelskejmeno); ?></h2>
        <?php
        if(isset($_SESSION["admin"])){
            echo '<form action="includes/deleteaccountScript.php?ID= ' . $ID_uzivatel . '" method="POST">
                <button type="submit" name="submit" onclick="return confirm(\'Opravdu chcete smazat tento účet? (účet bude instantně smazán a s tím i jeho příspěvky, toto nejde vrátit!)\')">Smazat účet</button>
            </form>';
        } 
        ?>
    </div>
    <a href="profil.php?ID=<?php echo $userID; ?>" class="<?php if($tab != "oblibene" && $tab != "privatni"){echo "active";}?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120Zm-40-160H240v60h480v-60Zm-480-60h480v-60H240v60Zm0-140h480v-240H240v240Zm0 200v60-60Zm0-60v-60 60Zm0-140v-240 240Zm0 80v-80 80Zm0 120v-60 60Z"/></svg>
        <p>Posty</p>
    </a>
    <?php if ($skryt_liky != 1) { ?>
    <a href="profil.php?ID=<?php echo $userID; ?>&TAB=oblibene" class="<?php if($tab == "oblibene"){echo "active";}?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
        <p>Oblíbené</p>
    </a>
    <?php } 
    if ($ID_uzivatel == $_SESSION["ID_uzivatel"]) { ?>
    <a href="profil.php?ID=<?php echo $userID; ?>&TAB=privatni" class="<?php if($tab == "privatni"){echo "active";}?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
        <p>Privátní</p>
    </a>
    <?php } ?>
    <a class="edit" href="nastaveni.php">Upravit profil</a>
    <hr>
</section>

<?php
if (!isset($_SESSION["ID_uzivatel"])) {
    header("location: ../index.php");
    exit();
}

if ($ID_uzivatel !== null) {
    if($tab == "oblibene" && $skryt_liky != 1){
        $sql = "SELECT o.ID_obrazky, o.ID_autor, o.nazev, o.cas, o.popis, o.oblibene, o.privatni, o.stahovatelne, u.uzivatelskejmeno, u.misto, u.profilovyobrazek, 
                (SELECT COUNT(*) FROM oblibene WHERE ID_obrazek = o.ID_obrazky AND ID_uzivatel = ?) AS liked
                FROM obrazky o
                INNER JOIN uzivatele u ON o.ID_autor = u.ID_uzivatel
                INNER JOIN oblibene ob ON o.ID_obrazky = ob.ID_obrazek
                WHERE ob.ID_uzivatel = ?
                ORDER BY o.cas DESC";
    }
    else if($tab == "privatni" && $ID_uzivatel == $_SESSION["ID_uzivatel"]){
        $sql = "SELECT o.ID_obrazky, o.ID_autor, o.nazev, o.cas, o.popis, o.oblibene, o.privatni, o.stahovatelne, u.uzivatelskejmeno, u.misto, u.profilovyobrazek, 
                (SELECT COUNT(*) FROM oblibene WHERE ID_obrazek = o.ID_obrazky AND ID_uzivatel = ?) AS liked
                FROM obrazky o
                INNER JOIN uzivatele u ON o.ID_autor = u.ID_uzivatel
                WHERE o.ID_autor = ? AND o.privatni = 1
                ORDER BY o.cas DESC";
        $showprivate = true;
    }
    else{
        $sql = "SELECT o.ID_obrazky, o.ID_autor, o.nazev, o.cas, o.popis, o.oblibene, o.privatni, o.stahovatelne, u.uzivatelskejmeno, u.misto, u.profilovyobrazek, 
                (SELECT COUNT(*) FROM oblibene WHERE ID_obrazek = o.ID_obrazky AND ID_uzivatel = ?) AS liked
                FROM obrazky o
                INNER JOIN uzivatele u ON o.ID_autor = u.ID_uzivatel
                WHERE o.ID_autor = ?
                ORDER BY o.cas DESC";
    }

    // Create a new statement object
    $stmt2 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt2, $sql)) {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt2, "ss", $ID_uzivatel, $ID_uzivatel);
    mysqli_stmt_execute($stmt2);

    $result = mysqli_stmt_get_result($stmt2);

    mysqli_stmt_close($stmt2); // Close the second statement
}
?>

<?php 
include_once 'includes/posts.php';
if (mysqli_num_rows($result) == 0){
    if($tab == "oblibene"){
        echo '<p class="nopost">Uživatel si neoblíbil žádné posty</p>';
    }
    else{
        echo '<p class="nopost">Uživatel nezveřejnil žádné posty</p>';
    }
}
?>