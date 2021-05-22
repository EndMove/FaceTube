<?php
$page = "list-member"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected() || !isAdmin()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Form action
$formAction = htmlspecialchars($_SERVER["PHP_SELF"]);

// Objet
$member = new member\Member($bdd);

// manage block
if (isset($_POST['blocked'])) {
  $id = secure::int($_POST['user_id']);

  $member->import($infoErrors, $id);
  $member->isblocked = !$member->isblocked;
  if ($member->update($infoErrors)) {
    $infoSucc = 'Membre mit à jour';
  }
}

// Récupération des utilisateurs
if (isset($_POST['search'])) {
  $queryRequest = secure::string($_POST['search']);
  $items = $member->search($infoErrors, $queryRequest);
} else {
  $items = $member->search($infoErrors);
  if (sizeof($items) == 1) {
    addError("Il n'y que votre compte enregistré (l'administrateur)", $infoErrors);
  }
}
