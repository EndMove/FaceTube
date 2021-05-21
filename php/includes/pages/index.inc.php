<?php
$page = "login"; include("core.php");

// Variable d'information sur les erreurs
$infoErrors = array();
$infoSucc   = '';

// Form action
$formAction = htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);

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
  $id = $member->auth($infoErrors, $login, $password);
  if ($id) {
    $member->import($infoErrors, $id);
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

// MSG ?
if (isset($_GET['msg'])) {
  $msg = secure::string($_GET['msg']);

  switch ($msg) {
    case 'rc':
      $infoSucc = 'Votre compte, toutes vos données, commentaires, vidéos... ont été supprimé de manière définitif de nos servers !';
      break;
  }
}