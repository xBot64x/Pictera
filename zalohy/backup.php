<?

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obrazky";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
  die("Připojení selhalo: " . $conn->connect_error);
}

$uploadOk = 1;
$target_dir = "uploads/";
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Je formulář?
if (isset($_POST["submit"])) {
  // Je obrázek?
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check === false) {
    echo "Soubor není obrázek.";
    $uploadOk = 0;
  }

  // Kontrola velikosti souboru
  if ($_FILES["fileToUpload"]["size"] > 50000000) { // 50MB limit
    echo "Soubor musí být menší než 50MB.";
    $uploadOk = 0;
  }

  // Ověření formátu obrázku
  $allowedFormats = ["jpg", "jpeg", "png", "gif", "webp"];
  if (!in_array($imageFileType, $allowedFormats)) {
    echo "Soubor smí být pouze jpg, jpeg, png, gif nebo webp.";
    $uploadOk = 0;
  }

  if ($uploadOk == 1) {
    // Ověření vstupů
    $ID_autor = $conn->real_escape_string($_POST["ID_autor"]);
    $nazev = $conn->real_escape_string($_POST["nazev"]);
    $popis = $conn->real_escape_string($_POST["popis"]);
    $misto = $conn->real_escape_string($_POST["misto"]);

    $povolit_stahovani = isset($_POST["povolit_stahovani"]) && $_POST["povolit_stahovani"] === "on" ? 1 : 0;
    $privatni = isset($_POST["privatni"]) && $_POST["privatni"] === "on" ? 1 : 0;

    $sql = "INSERT INTO `obrazky` (`ID_autor`, `nazev`, `cas`, `popis`, `oblibene`, `zhlednuti`, `stazeni`, `misto`, `stahovatelne`, `privatni`, `tagy`) 
                VALUES ('$ID_autor', '$nazev', CURRENT_TIMESTAMP, '$popis', 0, 0, 0, '$misto', $povolit_stahovani, $privatni, '')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      $target_file = $target_dir . $last_id . "." . $imageFileType;

      // Pokus o přesun souboru na server
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Soubor " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " byl nahrán.";
      } else {
        echo "Chyba při nahrávání obrázku.";
        // Odstranění záznamu z databáze při selhání
        $conn->query("DELETE FROM obrazky WHERE ID_obrazky = $last_id");
      }
    } else {
      echo "Chyba: " . $conn->error;
    }
  } else {
    echo "Soubor nebyl nahrán.";
  }
}

// Uzavření připojení
$conn->close();
?>

