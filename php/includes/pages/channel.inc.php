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
$channel = new video\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// Récupération données
$channel->import($infoErrors, $id, 1);
$member->import($infoErrors, $channel->fk_owner);
$videos = $video->exportAll($infoErrors, $id, 0);

// Sont amis ?
$mine = $channel->fk_owner == $_SESSION['account']['id'];
if (!$mine) {
  if (!$channel->ispublic || !$member->isFriend($infoErrors, $channel->fk_owner, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
}