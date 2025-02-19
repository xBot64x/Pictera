<?php if(isset($_SESSION["uzivatelskejmeno"])){ ?>
<nav class="sidebar">
    <a href='feed.php'>Pro tebe</a>
    <a href='feed.php?Order=cas'>Nové</a>
    <a href="profil.php?ID=<?php echo($_SESSION["uzivatelskejmeno"]);?>">Moje posty</a>
    <div class="lower">
        <a href="kontakt.php">Kontakt</a>
        <a href="podporit.php">Podpořit</a>
    </div>
</nav>
<script src="js/script.js"></script>

<script src="http://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(function(){
        $('a').each(function(){
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); $(this).parents('nav').addClass('active');
            }
        });
    });
</script>

<?php } ?>