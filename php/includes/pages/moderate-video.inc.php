<?php
$page = "edit-video"; include("core.php");

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
$video = new video\Video($bdd);

// Récupération de la vidéo
$video->setPriority(1);
$video->import($infoErrors, $id);

$block = $video->isblocked;

// manage block
if (isset($_POST['submit'])) {
  $blocked = secure::string($_POST['blocked']) == 'blocked';

  $video->isblocked = $blocked;
  if ($video->update($infoErrors)) {
    $infoSucc = 'Vidéo mise à jour';
  }
}
