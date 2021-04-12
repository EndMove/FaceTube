<?php
$page = "account"; include("core.php");

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
$channel = new video\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// Sont amis ?
$mine = $id == $_SESSION['account']['id'];
if (!$mine) {
  if (!$member->isFriend($infoErrors, $id, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
  $priority = 0;
} else $priority = 1;

// Get user and channel data
$channels = $channel->exportAll($infoErrors, $id, $priority);
$member->import($infoErrors, $id);