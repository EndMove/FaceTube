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
    <h1 class="text-center">Connexion</h1>
    <form id="form" method="POST" action="">
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email" placeholder="contact@endmove.eu">
      </div>
      <div class="field">
        <label for="password">Mot de passe</label><input type="password" id="password" name="password" placeholder="***********">
      </div>
      <div class="split">
        <div class="field multi-link">
          <a href="register.php"><i class="fas fa-user-plus"></i> Je n'ai pas encore de compte</a>
          <a href="forgot-pwd.php"><i class="fas fa-user-lock"></i> Mot de passe oublié</a>
        </div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Se connecter">
        </div>
      </div>
    </form>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>