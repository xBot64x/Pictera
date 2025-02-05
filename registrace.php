<?php include_once 'header.php' ?>

<section class="registrace">
  <form action="includes/registerScript.php" method="POST" enctype="multipart/form-data">
    <H1>Registrace</H1>
    <div class="input-container">
      <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
      </svg>
      <input type="text" name="e-mail" placeholder="e-mail">
    </div>
    <div class="input-container">
      <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
      </svg>
      <input type="text" name="uzivatelske_jmeno" placeholder="uživatelské jméno">
    </div>
    <div class="input-container">
      <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
      <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
      </svg>
      <input type="password" name="heslo" placeholder="heslo">
    </div>
    <div class="input-container">
      <svg class="icon" focusable="false" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
      <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
      </svg>
      <input type="password" name="heslo_opakovani" placeholder="zopakujte heslo">
    </div>

    <button type="submit" name="submit">Zaregistrovat se</button>

    <p style="color: var(--text2)">Už máte účet?</p><br><br>
    <a href="prihlaseni.php" style="color:var(--accent1)">Přihlášení</a>
  </form><br><br>

  <?php
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
      echo "<p>Zaplňte všechna pole</p>";
    } else if ($_GET["error"] == "invalidusername") {
      echo "<p>Uživatelské jméno nesmí obsahovat speciální znaky.</p>";
    } else if ($_GET["error"] == "invalidemail") {
      echo "<p>Zadejte platný email.</p>";
    } else if ($_GET["error"] == "passwordsdontmatch") {
      echo "<p>Hesla se neshodují.</p>";
    } else if ($_GET["error"] == "stmtfailed") {
      echo "<p>Nastala chyba, prosím zkuste to znovu.</p>";
    } else if ($_GET["error"] == "usernametaken") {
      echo "<p>Uživatelské jméno nebo email je již zabraný.</p>";
    } else if ($_GET["error"] == "none") {
      echo "<p>Byly jste zaregistrováni.</p>";
    }
  }
  ?>
</section>

<?php include_once 'footer.php' ?>