<?php
include_once 'header.php';
include_once 'sidebar.php';
include_once 'includes/database.php';

if (!isset($_SESSION["ID_uzivatel"]) || !isset($_GET["p"])) {
  header("location: ../index.php");
  exit();
}

$imageID = $_GET["p"];
$ID_uzivatel = $_SESSION["ID_uzivatel"];

// Retrieve and validate the 'Order' parameter
$order = isset($_GET['Order']) ? $_GET['Order'] : 'oblibene';
$valid_columns = ['ID_obrazky', 'ID_autor', 'nazev', 'cas', 'popis', 'oblibene', 'uzivatelskejmeno', 'misto'];
if (!in_array($order, $valid_columns)) {
  $order = 'oblibene';
}

$sql = "SELECT o.ID_obrazky, o.ID_autor, o.nazev, o.cas, o.popis, o.oblibene, o.privatni, o.stahovatelne, u.uzivatelskejmeno, u.misto, u.profilovyobrazek, 
        (SELECT COUNT(*) FROM oblibene WHERE ID_obrazek = o.ID_obrazky AND ID_uzivatel = ?) AS liked
        FROM obrazky o 
        INNER JOIN uzivatele u ON o.ID_autor = u.ID_uzivatel 
        WHERE o.ID_obrazky = ?";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header("location: ../profil.php?error=stmtfailed");
  exit();
}

mysqli_stmt_bind_param($stmt, "ss", $ID_uzivatel, $imageID);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

mysqli_stmt_close($stmt);

if (!$result) {
  echo "Chyba při načítání příspěvků: " . mysqli_error($conn);
  exit();
}
?>
<?php include_once 'includes/posts.php' ?>

<?php $post2 = mysqli_fetch_assoc($result) ?>

<p><?= $post2['popis'] ?></p>


<?php
mysqli_close($conn);
?>