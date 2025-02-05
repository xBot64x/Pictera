<?php include_once 'header.php'; ?>

<section class="upload">
    <h2>Vyberte možnost</h2>
    <a href="nahratobrazek.php">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M215.38-160q-23.05 0-39.22-16.16Q160-192.33 160-215.38v-529.24q0-23.05 16.16-39.22Q192.33-800 215.38-800h529.24q23.05 0 39.22 16.16Q800-767.67 800-744.62v529.24q0 23.05-16.16 39.22Q767.67-160 744.62-160H215.38Zm0-30.77h529.24q9.23 0 16.92-7.69 7.69-7.69 7.69-16.92v-529.24q0-9.23-7.69-16.92-7.69-7.69-16.92-7.69H215.38q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v529.24q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69Zm-24.61 0v-578.46 578.46ZM326-298.54h315.15q8.12 0 11.79-7.61 3.68-7.62-1.32-14.85l-83.93-112.15q-4.23-6-10.84-6-6.62 0-10.85 6l-99.23 122.69-60.23-74.08q-4.23-5.23-10.85-5.23-6.61 0-10.84 6L315.77-321q-5.23 7.23-1.56 14.85 3.67 7.61 11.79 7.61Zm14.16-286.08q14.69 0 24.96-10.43 10.26-10.43 10.26-25.11 0-14.69-10.43-24.96-10.43-10.26-25.11-10.26-14.69 0-24.96 10.43-10.26 10.43-10.26 25.11 0 14.69 10.43 24.96 10.43 10.26 25.11 10.26Z" />
        </svg>
    </a>
    <a href="nahrattext.php">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
            <path d="M215.38-160q-23.05 0-39.22-16.16Q160-192.33 160-215.38v-529.24q0-23.05 16.16-39.22Q192.33-800 215.38-800h529.24q23.05 0 39.22 16.16Q800-767.67 800-744.62v529.24q0 23.05-16.16 39.22Q767.67-160 744.62-160H215.38Zm0-30.77h529.24q9.23 0 16.92-7.69 7.69-7.69 7.69-16.92v-529.24q0-9.23-7.69-16.92-7.69-7.69-16.92-7.69H215.38q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v529.24q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69Zm-24.61-578.46v578.46-578.46Zm123.15 469.46h207.31q6.58 0 10.98-4.46 4.41-4.46 4.41-11.11 0-6.66-4.41-10.93-4.4-4.27-10.98-4.27H313.92q-6.57 0-10.98 4.46-4.4 4.46-4.4 11.12 0 6.65 4.4 10.92 4.41 4.27 10.98 4.27Zm0-164.85h332.16q6.57 0 10.98-4.45 4.4-4.46 4.4-11.12 0-6.66-4.4-10.93-4.41-4.26-10.98-4.26H313.92q-6.57 0-10.98 4.45-4.4 4.46-4.4 11.12 0 6.66 4.4 10.93 4.41 4.26 10.98 4.26Zm0-164.84h332.16q6.57 0 10.98-4.46 4.4-4.46 4.4-11.12 0-6.65-4.4-10.92-4.41-4.27-10.98-4.27H313.92q-6.57 0-10.98 4.46-4.4 4.46-4.4 11.11 0 6.66 4.4 10.93 4.41 4.27 10.98 4.27Z" />
        </svg>
    </a>
</section>
<section class="center">
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "none") {
            echo "<br><p>Post byl zveřejněn.</p>";
        }
    }
    ?>
</section>
<?php include_once 'footer.php'; ?>