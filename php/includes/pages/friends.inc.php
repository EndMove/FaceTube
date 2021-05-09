<?php
$page = "account"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Form action
$formAction = htmlspecialchars($_SERVER['PHP_SELF']);

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Objet membre
$member = new member\Member($bdd);

// Demander ami
if (isset($_POST['add_friend'])) {
  $login_email = secure::string($_POST['add_friend']);
  $id = $member->getID($infoErrors, $login_email);
  if ($id) {
    if ($member->updateFriend($infoErrors, $_SESSION['account']['id'], $id, 'add')) {
      $infoSucc = 'Votre demande d\'ami a été envoyé avec succès.';
    }
  }
}

// Accepter ami
if (isset($_POST['accept'])) {
  $id = secure::string($_POST['user_id']);
  if ($member->updateFriend($infoErrors, $_SESSION['account']['id'], $id, 'accept')) {
    $infoSucc = 'Vous avez accepté un nouvel ami, Yéyy !';
  }
}

// Refuser, supprimer, annuler ami
if (isset($_POST['cancel']) || isset($_POST['reject'])) {
  $id = secure::string($_POST['user_id']);
  if ($member->updateFriend($infoErrors, $_SESSION['account']['id'], $id, 'remove')) {
    $infoSucc = 'Vous venez de rejeter un début de relation';
  }
}
# -- remove
if (isset($_POST['remove'])) {
  $friendRemoveID = secure::string($_POST['user_id']);
}
# -- remove confirm
if (isset($_GET['rf'])) {
  $rf = secure::int($_GET['rf']);
  if ($member->updateFriend($infoErrors, $_SESSION['account']['id'], $rf, 'remove')) {
    $infoSucc = 'Vous venez de mettre fin à une relation Oo !';
  }
}

// Récupération des données (liste d'amis, demandes, en attente...)
$friendReceived = $member->getFriendRequestsReceived($infoErrors, $_SESSION['account']['id']);
$friendSent = $member->getFriendRequestsSent($infoErrors, $_SESSION['account']['id']);
$friendList = $member->getFriendList($infoErrors, $_SESSION['account']['id']);