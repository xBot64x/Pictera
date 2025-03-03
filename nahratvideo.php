<?php include_once 'header.php' ?>
<?php include_once 'sidebar.php' ?>

<?php
if (!isset($_SESSION["ID_uzivatel"])) {
  header("location: ./prihlaseni.php");
  exit();
}
?>

<section class="uploadtext">
  <form action="includes/uploadVideoScript.php" method="POST" enctype="multipart/form-data">
    <div class="formular">
      <input type="text" name="odkaz" placeholder="odkaz na youtube video *"></textarea>
      <input type="text" name="nazev" placeholder="popis *">
      <input type="text" name="misto" placeholder="místo">
      <br><br><br>
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
        } else if ($_GET["error"] == "") {
          echo "<p></p>";
        } else if ($_GET["error"] == "stmtfailed") {
          echo "<p>Nastala chyba, prosím zkuste to znovu.</p>";
        } else if ($_GET["error"] == "videoerror") {
          echo "<p>Neplatný odkaz na video.</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>Post byl zveřejněn.</p>";
        }
      }
      ?>
    </div>

  </form><br><br>
</section>

<script>
  const textArea = document.getElementById('text');
  const remainingChars = document.getElementById('remainingChars');

  textArea.addEventListener('input', () => {
    const maxLength = textArea.getAttribute('maxlength');
    const currentLength = textArea.value.length;
    remainingChars.textContent = `${maxLength - currentLength}`;
  });
</script>

<script src="js/upload.js"></script>
<?php include_once 'footer.php' ?>