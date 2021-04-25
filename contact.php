<?php
include("php/includes/pages/contact.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Contact</title>
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
    <?php showError($infoErrors); showSuccess($infoSucc); ?>
    <form id="form" class="contact" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="field">
        <label for="email" class="required">Email</label><input type="email" id="email" placeholder="Indiquez votre adresse email (requis pour la réponse de l'Admin)" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
      </div>
      <div class="field">
        <label for="subject" class="required">Sujet</label><input type="text" id="subject" placeholder="Indiquez le motif de la demande de contact" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>" required>
      </div>
      <div class="field">
        <label for="content" class="required">Message</label><textarea id="content" rows="8" placeholder="Rédigez votre message à l'intention de l'Admin ici" name="content"><?php echo isset($content) ? $content : ''; ?></textarea>
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