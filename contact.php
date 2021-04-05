<?php
$page = "contact"; include("core.php");
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
    <h1 class="text-center">Contacter un Administrateur</h1>
    <form id="form" class="contact" method="POST" action="">
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email">
      </div>
      <div class="field">
        <label for="subject">Sujet</label><input type="text" id="subject" name="subject">
      </div>
      <div class="field">
        <label for="content">Message</label><textarea id="content" rows="8"></textarea>
      </div>
      <div class="field btn">
        <input type="submit" name="submit" value="Envoyer">
      </div>
    </form>
  </main>

  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>