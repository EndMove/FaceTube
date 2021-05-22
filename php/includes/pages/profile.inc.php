<?php
$page = "profile"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Afficher profil de ?
if (!isset($_GET['id'])) {
  $id = $_SESSION['account']['id'];
} else $id = secure::int($_GET['id']);

// Objets
$channel = new channel\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// Sont amis ?
$mine = $id == $_SESSION['account']['id'];
if (!$mine && !isAdmin()) {
  if (!$member->isFriend($infoErrors, $id, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
  $channel->setPriority(0);
} elseif ($mine || isAdmin()) {
  $channel->setPriority(2);
  $video->setPriority(1);
}

// Get user and channel data
$channels = $channel->exportAll($infoErrors, $id);
$member->import($infoErrors, $id);

// MSG ?
if (isset($_GET['msg'])) {
  $msg = secure::string($_GET['msg']);

  switch ($msg) {
    case 'rc':
      $infoSucc = 'Votre chaîne a été supprimée avec succès !';
      break;
    case 'cc':
      $infoSucc = 'Votre nouvelle chaîne a été crée avec succès !';
      break;
  }
}