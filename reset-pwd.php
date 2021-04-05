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
    <h1 class="text-center">Réinitialiser mot de passe</h1>
    <form id="form" method="POST" action="">
      <div class="split">
        <div class="field">
          <label for="password">Mot de passe</label><input type="password" id="password" name="password" placeholder="***********">
        </div>
        <div class="field">
          <label for="repeat_password">Répeter mot de passe</label><input type="password" id="repeat_password" name="repeat_password" placeholder="***********">
        </div>
      </div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Réinitialiser">
        </div>
      </div>
      </form>
    </form>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>