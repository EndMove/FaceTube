<?php
include("php/includes/pages/forgot-pwd.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Mot de passe oublié</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Mot de passe oublié</h1>
    <?php showError($infoErrors); showSuccess($infoSucc); ?>
    <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="field">
        <label for="login" class="required">Email/Login</label><input type="text" id="login" name="login" placeholder="contact@endmove.eu / EndMove" value="<?php echo isset($login) ? $login : ''; ?>" required>
      </div>
      <div class="g-recaptcha" data-sitekey="<?php echo CONFIG['recaptchaV2']['recaptchasitekey']; ?>"></div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Envoyer l'Email">
        </div>
      </div>
    </form>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>