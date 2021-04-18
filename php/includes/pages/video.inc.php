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

// Get video id
if (!isset($_GET['id'])) {
  header('Location: ' . getRootUrl(true) . '/home.php');
  die();
} else $id = secure::int($_GET['id']);

// Objets
$channel = new video\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// récupération des données
$video->import($infoErrors, $id);
$channel->import($infoErrors, $video->fk_channel, 1);

// Sont amis ?
$mine = $channel->fk_owner == $_SESSION['account']['id'];
if (!$mine) {
  if (!$channel->ispublic || !$member->isFriend($infoErrors, $channel->fk_owner, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/home.php');
    die();
  }
}

// Evaluation
if (isset($_POST['like']) OR isset($_POST['unlike'])) {
  $action = isset($_POST['like']) ? 'like' : 'unlike';
  $video->addEvaluation($infoErrors, $_SESSION['account']['id'], $action);
  $video->evaluation = $video->countEvaluation($infoErrors);
}
$eval = $video->getEvaluationOfAMember($infoErrors, $_SESSION['account']['id']);

$video->addView($infoErrors, $_SESSION['account']['id']);