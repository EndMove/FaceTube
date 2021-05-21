<?php
$page = "home"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Show channel id ?
if (!isset($_GET['id'])) {
  header('Location: ' . getRootUrl(true) . '/home.php');
  die();
} else $id = secure::int($_GET['id']);

// Objets
$channel = new channel\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// Récupération données
$channel->setPriority(2);
$channel->import($infoErrors, $id);
$member->import($infoErrors, $channel->fk_owner);

// Sont amis ?
$mine = $channel->fk_owner == $_SESSION['account']['id'];
if (!$mine && !isAdmin()) {
  if (!$channel->ispublic || !$member->isFriend($infoErrors, $channel->fk_owner, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
// récupération des donnée finales
} elseif ($mine || isAdmin()) {
  $channel->setPriority(2);
  $video->setPriority(1);
  $channel->import($infoErrors, $id);
  $videos = $video->exportAll($infoErrors, $id, 0);
}
$videos = $video->exportAll($infoErrors, $id, 0);

if ($channel->isblocked) {
  addError('Cette chaine a été bloquée par un administrateur', $infoErrors);
}

// MSG ?
if (isset($_GET['msg'])) {
  $msg = secure::string($_GET['msg']);

  switch ($msg) {
   case 'rv':
     $infoSucc = 'La vidéo à été supprimé avec succès !';
     break;
   case 'cv':
     $infoSucc = 'La vidéo à été crée avec succès !';
     break;
  }
}