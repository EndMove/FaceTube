<?php
$page = "login"; include("core.php");

// Variable d'information sur les erreurs
$infoErrors = array();

// Redirige l'utilisateur si celui-ci est déjà connecté
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
  $login = secure::string($_POST['login']);
  $password = secure::string($_POST['password']);

  $member = new member\Member($bdd);
  $id = $member->auth($login, $password, $infoErrors);
  if ($id) {
    $member->import($id, $infoErrors);
    $_SESSION['account'] = $member->getData();
    if (isset($_GET['redirect'])) {
      header('Location: ' . urldecode($_GET['redirect']));
      die();
    } else {
      header('Location: ' . getRootUrl(true) . '/home.php');
      die();
    }
  }
}