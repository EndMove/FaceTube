<?php
include("php/includes/pages/about.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | À propos</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">À Propos</h1>
    <p>Hey, cette page est ici pour aider le développeur (moi) à naviger facilement dans le site FaceTube<br>
    Elle comprend la totalité des pages du site web. Dans un futur proche la page "À propos" sera une vrais page "À propos"... un jour peut-être.</p>
    <p><b>Encore beaucoup de chose à faire checkez le profile et les pages de ce coté</b> merci pour vos conseils (msg pour le prof)</p>
    <ul>
      <li><a href="home.php">Accueil</a></li>
      <li><a href="search.php">Rechercher</a></li>
      <li><a href="contact.php">Contacter</a></li>
      <li><a href="about.php">À propos (Non demandé dans EVAL_V2)</a></li>
      <li><a href="myaccount.php">Mon compte</a></li>
      <li><a href="video.php">Vidéos</a></li>
      <li><a href="logout.php">Déconnexion (Page effectuant la déconnexion et donc n'affiche aucun contenu)</a></li>
      <li><a href="index.php">Connexion</a></li>
      <li><a href="register.php">Créer un compte</a></li>
      <li><a href="forgot-pwd.php">Mot de passe oublié</a></li>
      <li><a href="reset-pwd.php">Reset mot de passe</a></li>
      <li><a href="test.php">Page de tests</a></li>
      <li><a href="edit-video.php">Èditer vidé</a></li>
      <li><a href="moderate-video.php">Modérer vidéo (Non demandé dans EVAL_V1, mais page existante)</a></li>
      <li><a href="channel.php">Chaîne</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>