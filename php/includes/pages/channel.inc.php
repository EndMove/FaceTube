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

// Show Profile of ?
if (!isset($_GET['id'])) {
  header('Location: ' . getRootUrl(true) . '/home.php');
  die();
} else $id = secure::int($_GET['id']);

// Objet Chaine
$channel = new video\Channel($bdd);
$member = new member\Member($bdd);

// Get data
$channel->import($infoErrors, $id);
$member->import($infoErrors, $channel->fk_owner);

// sont amis ?
if ($channel->fk_owner != $_SESSION['account']['id']) {
  if (!$member->isFriend($infoErrors, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
}