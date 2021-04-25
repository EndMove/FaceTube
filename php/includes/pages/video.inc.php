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

// Form action
$formAction = htmlspecialchars($_SERVER["PHP_SELF"]);

// Get video id
if (!isset($_GET['id'])) {
  header('Location: ' . getRootUrl(true) . '/profile.php');
  die();
} else $id = secure::int($_GET['id']);
$formAction .= "?id=$id";

// Objets
$channel = new video\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

// récupération des données
$video->import($infoErrors, $id);
$channel->setPriority(1);
$channel->import($infoErrors, $video->fk_channel);

// Sont amis ?
$mine = $channel->fk_owner == $_SESSION['account']['id'];
if (!$mine) {
  if (!$channel->ispublic || !$member->isFriend($infoErrors, $channel->fk_owner, $_SESSION['account']['id'])) {
    header('Location: ' . getRootUrl(true) . '/profile.php');
    die();
  }
}

// Evaluation
if (isset($_POST['evaluation'])) {
  $score = isset($_POST['score']) ?  $_POST['score'] : '-1';
  $video->addEvaluation($infoErrors, $_SESSION['account']['id'], $score);
  $video->evaluation = $video->countEvaluation($infoErrors);
}
$eval = $video->getEvaluationOfAMember($infoErrors, $_SESSION['account']['id']);

$video->addView($infoErrors, $_SESSION['account']['id']);