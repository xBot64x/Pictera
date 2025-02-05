<?php require_once 'includes/functions.php'; ?>

<section class="feed">
  <?php
  while ($post = mysqli_fetch_assoc($result)):
    if (!$post['privatni']) {
  ?>
      <div class="container">
        <a href="profil.php?ID=<?= htmlspecialchars($post['uzivatelskejmeno']) ?>">
          <div class="top">
            <img src="profiles/<?= htmlspecialchars($post['profilovyobrazek']) ?>.webp" alt="Profile">
            <span><?= htmlspecialchars($post['uzivatelskejmeno']) ?></span>
            <span class="right"><?= convertTime($post['cas']) ?></span>
          </div>
        </a>
        <div class="post">
          <a href="post.php?p=<?= htmlspecialchars($post['ID_obrazky']) ?>">
            <?php
            if (isset($post['nazev'])) {
              echo '<img src="uploads/' . htmlspecialchars($post['ID_obrazky']) . '.webp" alt="' . htmlspecialchars($post['nazev']) . '">';
            } else {
              echo "<pre>" . htmlspecialchars($post['popis']) . "</pre>";
            };
            ?>
          </a>
        </div>
        <div class="buttons">
          <a href="includes/likeScript.php?ID_obrazek=<?= htmlspecialchars($post['ID_obrazky']) ?>">
            <div>
              <?php if ($post['liked'] > 0): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                  <path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z" />
                </svg>
              <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                  <path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z" />
                </svg>
              <?php endif; ?>
            </div>
          </a>
          <span><?= htmlspecialchars($post['oblibene']) ?> oblíbené</span>
          <div class="dropdown">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                <path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z" />
              </svg>
            </div>
            <div class="dropdown-content">
              <?php
              if (isset($post['nazev'])) {
                if (($post['stahovatelne'] == 1 || $post['uzivatelskejmeno'] == $_SESSION['uzivatelskejmeno']) || isset($_SESSION['admin'])) {
                  echo ('<a href="uploads/' . htmlspecialchars($post['ID_obrazky']) . '.webp" download>Stáhnout</a>');
                } else {
                  echo ('<a class="gray">Stahování zakázáno</a>');
                }
              };
              ?>
              <?php $share_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/post.php?p="; ?>
              <a onclick="generatelink(this, '<?= $share_link ?><?= htmlspecialchars($post['ID_obrazky']) ?>')">Sdílet</a>
              <?php if ($post['uzivatelskejmeno'] == $_SESSION['uzivatelskejmeno'] || isset($_SESSION['admin'])) {
                echo ('<a href="includes/removescript.php?ID=' . $post['ID_obrazky'] . '" onclick="return confirm(\'Opravdu chcete tento příspěvek smazat?\')">Smazat</a>');
              };
              ?>

            </div>
          </div>
        </div>
        <div class="bot">
          <?php
          if (isset($post['nazev'])) {
            echo ('<span>' . htmlspecialchars($post['nazev']) . '</span>');
          }
          ?>
        </div>
        <svg class="squiggle" viewBox="0 0 199 7" xmlns="http://www.w3.org/2000/svg">
          <path d="M1 3.5C5.7381 0.166667 10.4762 0.166667 15.2143 3.5C19.9524 6.83333 24.6905 6.83333 29.4286 3.5C34.1667 0.166667 38.9048 0.166667 43.6429 3.5C48.381 6.83333 53.119 6.83333 57.8571 3.5C62.5952 0.166667 67.3333 0.166667 72.0714 3.5C76.8095 6.83333 81.5476 6.83333 86.2857 3.5C91.0238 0.166667 95.7619 0.166667 100.5 3.5C105.238 6.83333 109.976 6.83333 114.714 3.5C119.452 0.166667 124.19 0.166667 128.929 3.5C133.667 6.83333 138.405 6.83333 143.143 3.5C147.881 0.166667 152.619 0.166667 157.357 3.5C162.095 6.83333 166.833 6.83333 171.571 3.5C176.31 0.166667 181.048 0.166667 185.786 3.5C190.524 6.83333 195.262 6.83333 200 3.5" stroke-width="2" />
        </svg>
      </div>
  <?php }
  endwhile; ?>
</section>