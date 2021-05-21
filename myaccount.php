<?php
include("php/includes/pages/myaccount.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Mon compte</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Votre compte</h1>
    <?php showError($infoErrors); showSuccess($infoSucc);
    if (isset($_POST['remove'])) {
      showInfo('<a href="' . $formAction . '?rc=true">Cliquez-ici</a> pour confirmer la suppression de votre compte (ATENTION ! cette action est iréversible).');
    }
    ?>
    <form id="form" class="myaccount" method="POST" action="<?php echo $formAction; ?>">
      <div class="field">
        <label for="lastname" class="required">Nom</label><input type="text" id="lastname" name="lastname" placeholder="Nihart" value="<?php echo isset($lastname) ? $lastname : $_SESSION['account']['lastname']; ?>" required>
      </div>
      <div class="field">
        <label for="firstname" class="required">Prénom</label><input type="text" id="firstname" name="firstname" placeholder="Jérémi" value="<?php echo isset($firstname) ? $firstname : $_SESSION['account']['firstname']; ?>" required>
      </div>
      <div class="field">
        <label for="pseudonym" class="required">Pseudonyme</label><input type="text" id="pseudonym" name="pseudonym" placeholder="EndMove" value="<?php echo isset($pseudonym) ? $pseudonym : $_SESSION['account']['login']; ?>" required>
      </div>
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email" placeholder="contact@endmove.eu" value="<?php echo $_SESSION['account']['email']; ?>" disabled>
      </div>
      <div class="field">
        <label for="password">Nouveau mot de passe</label><input type="password" id="password" name="password" placeholder="***********">
      </div>
      <div class="field">
        <label for="repeat_password">Répéter nouveau mot de passe</label><input type="password" id="repeat_password" name="repeat_password" placeholder="***********">
      </div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Sauvegarder">
        </div>
      </div>
    </form>

    <div class="myaccount flex jsf-center">
      <form method="POST" action="<?php echo $formAction; ?>">
        <input class="red" type="submit" name="remove" value="(!) Supprimer le compte (!)">
      </form>
    </div>

  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>