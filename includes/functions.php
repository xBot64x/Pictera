<?php

//registrace

function emptyInputSignup($email, $uzivatelskejmeno, $heslo, $heslo_opakovani)
{
    $result = false;
    if (empty($email) || empty($uzivatelskejmeno) || empty($heslo_opakovani) || empty($heslo)) {
        $result = true;
    }
    return $result;
}

function invalidUsername($uzivatelskejmeno)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9 _-]*$/", $uzivatelskejmeno)) {
        $result = true;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    return $result;
}

function pwdMatch($heslo, $heslo_opakovani)
{
    $result = false;
    if ($heslo !== $heslo_opakovani) {
        $result = true;
    }
    return $result;
}

function usernameExists($conn, $uzivatelskejmeno, $email)
{
    $sql = "SELECT * FROM uzivatele WHERE uzivatelskejmeno = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../registrace.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $uzivatelskejmeno, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $heslo, $uzivatelskejmeno)
{
    $sql = "INSERT INTO uzivatele (email, heslo, uzivatelskejmeno) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../registrace.php?error=stmtfailed");
        exit();
    }

    $hashedpassword = password_hash($heslo, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $email, $hashedpassword, $uzivatelskejmeno);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    session_start();
    $_SESSION["ID_uzivatel"] = mysqli_insert_id($conn);
    $_SESSION["uzivatelskejmeno"] = $uzivatelskejmeno;
    $_SESSION["profilovyobrazek"] = "default";
    header("location: ../feed.php");
    exit();
}


// prihlaseni

function emptyInputLogin($jmeno, $heslo)
{
    $result = false;
    if (empty($heslo) || empty($jmeno)) {
        $result = true;
    }
    return $result;
}

function loginUser($conn, $jmeno, $heslo)
{
    $jmenoExistuje = usernameExists($conn, $jmeno, $jmeno);

    if ($jmenoExistuje === false) {
        header("location: ../prihlaseni.php?error=nouser");
        exit();
    }

    $hashedpassword = $jmenoExistuje["heslo"];
    $checkpassword = password_verify($heslo, $hashedpassword);

    if ($checkpassword === false) {
        header("location: ../prihlaseni.php?error=wronglogin");
        exit();
    } else if ($checkpassword === true) {
        session_start();
        session_unset();
        if ($jmenoExistuje["uzivatelskejmeno"] == "admin") {
            $_SESSION["admin"] = true;
        }
        $_SESSION["ID_uzivatel"] = $jmenoExistuje["ID_uzivatel"];
        $_SESSION["uzivatelskejmeno"] = $jmenoExistuje["uzivatelskejmeno"];
        $_SESSION["profilovyobrazek"] = $jmenoExistuje["profilovyobrazek"];
        header("location: ../feed.php");
        exit();
    }
}


// upload

function emptyInputUpload($nazev, $obrazek)
{
    $result = false;
    if (empty($nazev) || empty($obrazek)) {
        $result = true;
    }
    return $result;
}

function emptyInputUploadText($nazev)
{
    $result = false;
    if (empty($nazev)) {
        $result = true;
    }
    return $result;
}

function emptyinputUploadVideo($odkaz, $nazev)
{
    $result = false;
    if (empty($odkaz) || empty($nazev)) {
        $result = true;
    }
    return $result;
}

function invalidFileType($obrazek)
{
    $result = false;
    try {
        $check = getimagesize($obrazek["tmp_name"]);
        if ($check == false) {
            $result = true;
        }
    } catch (Exception $e) {
        $result = true;
    }
    return $result;
}

function uploadImage($conn, $nazev, $popis, $misto, $ID_autor, $obrazek, $privatni, $stahovatelne)
{
    mysqli_begin_transaction($conn);

    try {
        $sql = "INSERT INTO obrazky (nazev, popis, misto, ID_autor, privatni, stahovatelne) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("Statement preparation failed");
        }

        mysqli_stmt_bind_param($stmt, "ssssss", $nazev, $popis, $misto, $ID_autor, $privatni, $stahovatelne);
        mysqli_stmt_execute($stmt);
        $lastID = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        $target_file = '../uploads/' . $lastID . '.webp';

        if (!convertImageToWebp($obrazek["tmp_name"], $target_file)) {
            throw new Exception("Image upload failed");
        }

        // otočení
        $image = fixrotation($obrazek, $target_file);

        limitsize($image, $target_file, 800, 1424);

        mysqli_commit($conn);
        
        if ($privatni) {
            header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"] . "&TAB=privatni");
        } else {
            header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"]);
        }
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);

        if (isset($target_file) && file_exists($target_file)) {
            unlink($target_file);
        }

        header("location: ../nahrat.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

function fixrotation($obrazek, $target_file){ //return image
    $image = imagecreatefromwebp($target_file);
    $exif = exif_read_data($obrazek["tmp_name"]);
    if (isset($exif['Orientation'])) {
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
    }
    return $image;
}

function limitsize($image, $target_file ,$maxwidth, $maxheight){
    $width = imagesx($image);
    $height = imagesy($image);

    if ($width > $maxwidth || $height > $maxheight) {
        $newWidth = $maxwidth;
        $newHeight = $maxheight;
        if ($width > $height) {
            $newHeight = $height * $maxwidth / $width;
        } else {
            $newWidth = $width * $maxheight / $height;
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagewebp($newImage, $target_file, 100);
        imagedestroy($newImage);
    } else {
        imagewebp($image, $target_file, 100);
    }

    imagedestroy($image);
}

function uploadText($conn, $text, $misto, $privatni, $ID_autor)
{
    $sql = "INSERT INTO obrazky (popis, misto, privatni, ID_autor) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        throw new Exception("Statement preparation failed");
    }

    mysqli_stmt_bind_param($stmt, "ssss", $text, $misto, $privatni, $ID_autor);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_commit($conn);

    if ($privatni) {
        header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"] . "&TAB=privatni");
    } else {
        header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"]);
    }
    exit();
}

function uploadVideo($conn, $odkaz, $nazev, $misto, $privatni, $ID_autor)
{
    // fix youtu.be share links to normal links eg: https://youtu.be/F7041I-6sRw?si=EkXaxblhZG5uiswE to https://www.youtube.com/watch?v=F7041I-6sRw and remove ?si=EkXaxblhZG5uiswE, add embed/ to the link
    $odkaz = preg_replace('/youtu\.be\/([a-zA-Z0-9_-]+)(\?.*)?/', 'www.youtube.com/watch?v=$1', $odkaz);
    $odkaz = preg_replace('/watch\?v=([a-zA-Z0-9_-]+)(\?.*)?/', 'embed/$1', $odkaz);

    $sql = "INSERT INTO obrazky (odkaz, nazev, misto, privatni, ID_autor) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nahratvideo.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $odkaz, $nazev, $misto, $privatni, $ID_autor);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($privatni) {
        header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"] . "&TAB=privatni");
    } else {
        header("location: ../profil.php?ID=" . $_SESSION["uzivatelskejmeno"]);
    }
    exit();
}

function convertImageToWebp(string $inputFile, string $outputFile, int $quality = 100): bool
{
    $fileType = exif_imagetype($inputFile);
    $success = false;

    try {
        switch ($fileType) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($inputFile);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($inputFile);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($inputFile);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case IMAGETYPE_WEBP:
                return rename($inputFile, $outputFile);
            default:
                return false;
        }

        $success = imagewebp($image, $outputFile, $quality);
        imagedestroy($image);
    } catch (Exception $e) {
        $success = false;
    }

    return $success;
}

// nastaveni
function setprofilepicture($conn, $obrazek, $ID_uzivatel)
{
    $sql = "UPDATE uzivatele SET profilovyobrazek = ? WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $ID_uzivatel, $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION["profilovyobrazek"] = $ID_uzivatel;

    $target_file = '../profiles/' . $ID_uzivatel . '.webp';

    try {
        if (!convertImageToWebp($obrazek["tmp_name"], $target_file)) {
            throw new Exception("Image upload failed");
        }
        $image = fixrotation($obrazek, $target_file);
        limitsize($image, $target_file, 256, 256);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("location: ../nastaveni.php?error=uploadfailed");
        $_SESSION["profilovyobrazek"] = "default";
        exit();
    }
    header("location: ../nastaveni.php?error=none");
    exit();
}

function removeprofilepicture($conn, $ID_uzivatel)
{
    $sql = "UPDATE uzivatele SET profilovyobrazek = default WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION["profilovyobrazek"] = "default";

    if (file_exists('../profiles/' . $ID_uzivatel . '.webp')) {
        unlink('../profiles/' . $ID_uzivatel . '.webp');
    }
    header("location: ../nastaveni.php?error=none");
    exit();
}

function deleteaccount($conn, $ID_uzivatel, $admin)
{
    // smazat uzivatele z databaze
    $sql = "DELETE FROM uzivatele WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $profile = '../profiles/' . $ID_uzivatel . '.webp';
    if (file_exists($profile)) {
        unlink($profile);
    }

    // smazat soubory postu
    $sql = "SELECT ID_obrazky FROM obrazky WHERE ID_autor = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $file = '../uploads/' . $row['ID_obrazky'] . '.webp';
        if (file_exists($file)) {
            unlink($file);
        }
    }
    mysqli_stmt_close($stmt);

    // smazat posty z databaze
    $sql = "DELETE FROM obrazky WHERE ID_autor = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if (!$admin) {
        session_unset();
        session_destroy();
        header("location: ../index.php");
        exit();
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function changeusername($conn, $ID_uzivatel, $novejmeno)
{
    $jmenoExistuje = usernameExists($conn, $novejmeno, $novejmeno);

    if ($jmenoExistuje === true) {
        header("location: ../nastaveni.php?error=nouser");
        exit();
    }

    $sql = "UPDATE uzivatele SET uzivatelskejmeno = ? WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $novejmeno, $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    session_start();
    $_SESSION["uzivatelskejmeno"] = $novejmeno;
    header("location: ../nastaveni.php?error=none");
    exit();
}

function changeemail($conn, $ID_uzivatel, $email)
{
    $sql = "UPDATE uzivatele SET email = ? WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../nastaveni.php?error=none");
    exit();
}

function changepassword($conn, $ID_uzivatel, $heslo, $stareheslo)
{
    $sql = "SELECT heslo FROM uzivatele WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $hashedpassword = $row["heslo"];
        $checkpassword = password_verify($stareheslo, $hashedpassword);

        if ($checkpassword === false) {
            header("location: ../nastaveni.php?error=wrongpassword");
            exit();
        } else if ($checkpassword === true) {
            $sql = "UPDATE uzivatele SET heslo = ? WHERE ID_uzivatel = ?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../nastaveni.php?error=stmtfailed");
                exit();
            }

            $hashedpassword = password_hash($heslo, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ss", $hashedpassword, $ID_uzivatel);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location: ../nastaveni.php?error=none");
            exit();
        }
    }
}

function changepasswordadmin($conn, $ID_uzivatel, $heslo)
{
    $sql = "UPDATE uzivatele SET heslo = ? WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }

    $hashedpassword = password_hash($heslo, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ss", $hashedpassword, $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../admin.php?TAB=uzivatele&error=none");
    exit();
}

function checkskrytliky($conn, $ID_uzivatel)
{
    $sql = "SELECT skryt_liky FROM uzivatele WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $ID_uzivatel);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['skryt_liky'] == 1 ? "checked" : "";
    }
    return "";
}

function hideLikes($conn, $ID_uzivatel, $privatni)
{
    $sql = "UPDATE uzivatele SET skryt_liky = ? WHERE ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../nastaveni.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $privatni, $ID_uzivatel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../nastaveni.php?TAB=soukromi");
    exit();
}

// posty

function convertTime($time)
{
    $timeZone = new DateTimeZone('Europe/Prague');
    $time1 = new DateTime($time, $timeZone);
    $now = new DateTime('now', $timeZone);
    $interval = $time1->diff($now, true);

    if ($interval->y) {
        return 'před ' . $interval->y . ' ' . zkolonovani($interval->y, 'rokem', 'roky', 'let');
    } elseif ($interval->m) {
        return 'před ' . $interval->m . ' ' . zkolonovani($interval->m, 'měsícem', 'měsíci', 'měsíci');
    } elseif ($interval->d) {
        return 'před ' . $interval->d . ' ' . zkolonovani($interval->d, 'dnem', 'dny', 'dny');
    } elseif ($interval->h) {
        return 'před ' . $interval->h . ' ' . zkolonovani($interval->h, 'hodinou', 'hodinami', 'hodinami');
    } elseif ($interval->i) {
        return 'před ' . $interval->i . ' ' . zkolonovani($interval->i, 'minutou', 'minutami', 'minutami');
    } else {
        return "před méně než minutou";
    }
}

function zkolonovani($number, $form1, $form2, $form5)
{
    if ($number == 1) {
        return $form1;
    } elseif ($number >= 2 && $number <= 4) {
        return $form2;
    } else {
        return $form5;
    }
}

function removePost($conn, $ID_obrazky, $ID_autor)
{
    if (isset($_SESSION["admin"])) {
        $sql = "DELETE FROM obrazky WHERE ID_obrazky = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../feed.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $ID_obrazky);
    } else {
        $sql = "DELETE FROM obrazky WHERE ID_obrazky = ? AND ID_autor = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../feed.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $ID_obrazky, $ID_autor);
    }
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $file = '../uploads/' . $ID_obrazky . '.webp';
        if (file_exists($file)) {
            unlink($file);
        }
    }

    mysqli_stmt_close($stmt);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function emptyInputRemove($ID_obrazky, $ID_autor)
{
    $result = false;
    if (empty($ID_obrazky) || empty($ID_autor)) {
        $result = true;
    }
    return $result;
}

function likePost($conn, $ID_obrazek, $ID_uzivatel)
{
    $sql = "SELECT * FROM oblibene WHERE ID_obrazek = ? AND ID_uzivatel = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../feed.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $ID_obrazek, $ID_uzivatel);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultData) == 0) {
        $sql = "INSERT INTO oblibene (ID_obrazek, ID_uzivatel) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../feed.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $ID_obrazek, $ID_uzivatel);
        mysqli_stmt_execute($stmt);
    } else {
        $sql = "DELETE FROM oblibene WHERE ID_obrazek = ? AND ID_uzivatel = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../feed.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $ID_obrazek, $ID_uzivatel);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    $sql = "UPDATE obrazky SET oblibene = (SELECT COUNT(*) FROM oblibene WHERE ID_obrazek = ?) WHERE ID_obrazky = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../feed.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $ID_obrazek, $ID_obrazek);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function displayTextWithLinks($s)
{
    return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1">$1</a>', $s);
}
