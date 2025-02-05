<?php include_once 'header.php' ?>

<section class="prihlaseni">
    <form action="includes/loginScript.php" method="POST" enctype="multipart/form-data">
        <H1>Přihlášení</H1>

        <div class="input-container">
            <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
            </svg>
            <input type="text" name="uzivatelskejmeno" placeholder="email / uživatelské jméno">
        </div>
        <div class="input-container">
            <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
            </svg>
            <input type="password" name="heslo" placeholder="heslo">
        </div>
        <a href="#" style="color:var(--accent1)">zapomenuté heslo</a>

        <button type="submit" name="submit">Přihlásit se</button>

        <p style="color: var(--text2)">Namáte účet?</p><br><br>
        <a href="registrace.php" style="color:var(--accent1)">Registrace</a>
    </form><br><br>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Zaplňte všechna pole</p>";
        } else if ($_GET["error"] == "nouser") {
            echo "<p>Uživatel neexistuje.</p>";
        } else if ($_GET["error"] == "wronglogin") {
            echo "<p>Špatné heslo.</p>";
        }
    }
    ?>
</section>



<?php include_once 'footer.php' ?>