<?php
include("php/includes/pages/index.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Connexion</title>
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
    <?php showError($infoErrors); ?>
    <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="field">
        <label for="login" class="required">Email/Login</label><input type="text" id="login" name="login" placeholder="contact@endmove.eu / EndMove" value="<?php echo isset($login) ? $login : ''; ?>" required>
      </div>
      <div class="field">
        <label for="password" class="required">Mot de passe</label><input type="password" id="password" name="password" placeholder="***********" required>
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