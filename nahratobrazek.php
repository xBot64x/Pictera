<?php include_once 'header.php' ?>
<?php include_once 'sidebar.php' ?>

<?php
if (!isset($_SESSION["ID_uzivatel"])) {
  header("location: ../prihlaseni.php");
  exit();
}
?>

<section class="uploadimage">
  <form action="includes/uploadScript.php" method="POST" enctype="multipart/form-data">
    <div class="image">
      <input accept="image/png, image/jpeg, image/jpg, image/webp" type='file' id="imgInp" name='obrazek'>
      <label for="imgInp" class="custom-file-upload">
        Nahrát obrázek
      </label>
      <img id="preview">
    </div>
    <div class="formular">
      <input type="text" name="nazev" placeholder="název *">
      <textarea type="text" name="popis" placeholder="popis"></textarea>
      <input type="text" name="misto" placeholder="místo">
      <input type="text" name="tagy" placeholder="tagy">
      <p style="color: var(--text2);">oddělte mezerou</p>
      <br><br><br>
      <label class="switch">
        <input type="checkbox" name="zakazatstahovani">
        <span class="slider"></span>
      </label>
      <label for="zakazatstahovani">zakázat stahování</label><br><br><br><br><br>
      <label class="switch">
        <input type="checkbox" name="privatni">
        <span class="slider"></span>
      </label>
      <label for="privatni">privátní</label><br>

      <button type="submit" name="submit">Sdílet</button>
      <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Zaplňte všechna požadovaná pole.</p>";
        } else if ($_GET["error"] == "invalidfiletype") {
          echo "<p>Neplatý formát obrázku.</p>";
        } else if ($_GET["error"] == "") {
          echo "<p></p>";
        } else if ($_GET["error"] == "uploadfailed") {
          echo "<p>Nastala chyba při nahrávání obrázku.</p>";
        } else if ($_GET["error"] == "stmtfailed") {
          echo "<p>Nastala chyba, prosím zkuste to znovu.</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>Post byl zveřejněn.</p>";
        }
      }
      ?>
    </div>

  </form><br><br>
</section>


<script src="js/upload.js"></script>
<?php include_once 'footer.php' ?>