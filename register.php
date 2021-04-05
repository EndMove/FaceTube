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
    <h1 class="text-center">Inscription</h1>
    <form id="form" method="POST" action="">
      <div class="split">
        <div class="field">
          <label for="lastname">Nom</label><input type="text" id="lastname" name="lastname" placeholder="Nihart">
        </div>
        <div class="field">
          <label for="firstname">Prénom</label><input type="text" id="firstname" name="firstname" placeholder="Jérémi">
        </div>
      </div>
      <div class="field">
        <label for="pseudonym">Pseudonyme</label><input type="text" id="pseudonym" name="pseudonym" placeholder="EndMove">
      </div>
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email" placeholder="contact@endmove.eu">
      </div>
      <div class="field split">
        <div class="field">
          <label for="password">Mot de passe</label><input type="password" id="password" name="password" placeholder="***********">
        </div>
        <div class="field">
          <label for="repeat_password">Mot de passe</label><input type="password" id="repeat_password" name="repeat_password" placeholder="***********">
        </div>
      </div>
      <div class="split">
        <div class="field link">
          <a href="index.php"><i class="fas fa-sign-in-alt"></i> J'ai déjà un compte</a>
        </div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="S'Inscrire">
        </div>
      </div>
    </form>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>