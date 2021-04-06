<?php
$page = "login"; include("core.php");

// Variable d'information sur les erreurs
$infoErrors = array();

// Redirige l'utilisateur
if (isConnected()) {
  if (isset($_GET['redirect'])) {
    header('Location: ' . urldecode($_GET['redirect']));
    die();
  } else {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
}

// Connexion
if (isset($_POST['submit'])) {
  $email = secure::string($_POST['email']);
  $password = secure::string($_POST['password']);

  $member = new member\Member($bdd);
  $id = $member->auth($email, $password, $infoErrors);
  if ($id) {
    $member->import($id, $infoErrors);
    $_SESSION['account'] = $member->getData();
  }
}

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
    <?php showError($infoErrors); ?>
    <form id="form" method="POST" action="">
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email" placeholder="contact@endmove.eu" value="<?php echo isset($email) ? $email : ''; ?>">
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