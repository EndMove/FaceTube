<?php
include("php/includes/pages/contact.inc.php");
if (isset($_POST['submit'])) {

}
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