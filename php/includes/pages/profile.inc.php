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
$mine = $id == $_SESSION['account']['id'];

// Objet Chaine
$channel = new video\Channel($bdd);
$member = new member\Member($bdd);

// Sont amis ?
if (!$mine) {
  if (!$member->isFriend($infoErrors, $id, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
}

// Get user and channel data
$channels = $channel->exportAll($infoErrors, $id);
$member->import($infoErrors, $id);