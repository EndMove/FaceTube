<?php
$page = "edit-channel"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected() || !isAdmin()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Form action
$formAction = htmlspecialchars($_SERVER["PHP_SELF"].'?'.$_SERVER['QUERY_STRING']);

// Get id of video
if (!isset($_GET['id'])) {
  header('Location: ' . getRootUrl(true) . '/profile.php');
  die();
} else $id = secure::int($_GET['id']);

// Objet
$channel = new channel\Channel($bdd);

// Récupération de la vidéo
$channel->setPriority(2);
$channel->import($infoErrors, $id);

$block = $channel->isblocked;

// manage block
if (isset($_POST['submit'])) {
  $blocked = secure::string($_POST['blocked']) == 'blocked';

  $channel->isblocked = $blocked;
  if ($channel->update($infoErrors)) {
    $infoSucc = 'Chaîne mise à jour';
  }
}
