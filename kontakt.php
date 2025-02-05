<?php include_once 'header.php';?>
<?php include_once 'sidebar.php';?>

<section class="center">
    <h1>Pictera kontakt</h1>
    <p>Pro kontaktování nás můžete použít následující formulář:</p>
    <form action="includes/contactScript.php" method="POST">
        <input type="text" name="jmeno" placeholder="Jméno">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="predmet" placeholder="Předmět">
        <textarea name="zprava" placeholder="Zpráva"></textarea>
        <button type="submit" name="submit">Odeslat</button>
    </form>
    <p>Nebo nás můžete kontaktovat na emailu: <a href="mailto:
        <?php
        $email = "Bot64@proton.me";
        echo $email;
        ?>
    "><?php echo $email; ?></a></p>
    <p>Nebo nás můžete kontaktovat na telefonu: <a href="tel:+420123456789">+420 123 456 789</a></p>
    <p>Nebo nás můžete kontaktovat na adrese: <a href="https
        <?php
        $adresa = "://www.google.com/maps/place/Brno";
        echo $adresa;
        ?>
    "><?php echo $adresa; ?></a></p>
    <p>Nebo nás můžete kontaktovat na sociálních sítích: <a href="https://www.facebook.com">Facebook</a>, <a href="https://www.instagram.com">Instagram</a>, <a href="https://www.twitter.com">Twitter</a></p>
    <p>Nebo nás můžete kontaktovat osobně na adrese: <a href="https
        <?php
        $adresa = "://www.google.com/maps/place/Brno";
        echo $adresa;
        ?>
    "><?php echo $adresa; ?></a></p>
            
</section>

<?php include_once 'footer.php';?>