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
  header('Location: ' . getRootUrl(true) . '/profile.php');
  die();
} else $id = secure::int($_GET['id']);

// Form action
$formAction = htmlspecialchars($_SERVER['PHP_SELF'].'?id='.$id);

// Objets
$channel = new channel\Channel($bdd);
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

// Evaluation(s)
if (isset($_POST['evaluation'])) {
  $score = isset($_POST['score']) ?  $_POST['score'] : '-1';
  $video->evaluationObject->addEvaluation($infoErrors, $_SESSION['account']['id'], $score);
  $video->evaluation = $video->evaluationObject->count($infoErrors);
}
$eval = $video->evaluationObject->getEvaluationOfAMember($infoErrors, $_SESSION['account']['id']);

// Commentaire(s)
# -- remove
if (isset($_POST['comment_remove'])) {
  $commentRemoveID = secure::int($_POST['comment_remove']);
}

# -- remove confirm
if (isset($_GET['rc'])) {
  $rc = secure::int($_GET['rc']);
  $video->commentObject->remove($infoErrors, $rc, $_SESSION['account']['id']);
}

# -- create
if (isset($_POST['comment_submit'])) {
  $comment = Secure::string($_POST['comment_value']);
  $video->commentObject->add($infoErrors, $_SESSION['account']['id'], $comment);
  $video->comment = $video->commentObject->count($infoErrors);
}
$com = $video->commentObject->getAll($infoErrors);

// AddView
$video->addView($infoErrors, $_SESSION['account']['id']);