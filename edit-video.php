<?php
$page = "contact"; include("php/core.php");
/**
 * Powered By EndMove 2020-2021 All Rights Reserved.
 * Version: 1.0 - Date: 24-12-2020
 */

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Ajouter ou modifier une vidéo</h1>
    <form id="form" method="POST" action="">
      <div class="field">
        <label for="channel">Chaîne de publication</label>
        <select id="channel" name="channel">
          <option value="#">K/DA</option>
          <option value="#">EndMoveMovie</option>
        </select>
      </div>
      <div class="field">
        <label for="title">Titre</label><input type="text" id="title" name="title" placeholder="Titre de la vidéo" value="MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)">
      </div>
      <div class="field">
        <label for="description">Description</label><textarea id="description" name="description" value="Contenu" rows="5">Montez sur le trône. K/DA est de retour avec « MORE », qui regroupe Madison Beer, SOYEON et MIYEON de (G)I-DLE, Lexie Liu, Jaira Burns et Séraphine. K/DA est un super-groupe musical composé d'Ahri, Evelynn, Akali et Kai'Sa. Ne manquez pas leur prochain EP, ALL OUT, qui paraîtra le 6 novembre 2020. Suivez l'actualité de @KDA_MUSIC sur Twitter et Instagram.</textarea>
      </div>
      <div class="field">
        <label for="html_fragment">HTML5 Fragment</label><input type="text" id="html_fragment" name="html_fragment" placeholder="https://####.##" value="https://www.youtube.com/embed/3VTkBuxU4yk">
      </div>
      <div class="field">
        <label for="banner">Mignature</label><input type="text" id="banner" name="banner" placeholder="https://####.##/####.##" value="upload/mignature02.webp">
      </div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Enregistrer">
        </div>
      </div>
    </form>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>