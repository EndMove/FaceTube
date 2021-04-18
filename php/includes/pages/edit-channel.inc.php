<?php
$page = "home"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected()) {
  header('Location: ' . getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Objet Chaine
$channel = new video\Channel($bdd);
$video = new video\Video($bdd);

// Variable par défaut
$public = false;
$name = NULL;

// Option GET (charger chaine existante || supprimer chaine).
if (isset($_GET['id'])) {
  $id = secure::int($_GET['id']);
  // Récupérer chaine et vérifier qu'on est propriétaire
  $channel->import($infoErrors, $id, 1);
  if ($channel->fk_owner != $_SESSION['account']['id']) {
    header('Location: ' . getRootUrl(true) . '/profile.php');
    die();
  }
  // Options
  if (isset($_GET['option'])) {
    $option = secure::string($_GET['option']);
    switch ($option) {
      case 'remove':
        $videos = $video->exportAll($infoErrors, $id);
        if ($videos !== false) {
          foreach ($videos as $vi) {
            $vi->remove($infoErrors);
          }
        }
        $channel->remove($infoErrors);
        header('Location: ' . getRootUrl(true) . '/profile.php');
        die();
      default:
        addError("Option inconnue merci de vérifier votre requète HTTP", $infoErrors);
        break;
    }
  }
  $name = $channel->name;
  $public = $channel->ispublic;
}

// Option POST (mettre à jour chaine || créer chaine).
if (isset($_POST['submit'])) {
  $name = secure::string($_POST['name']);
  $public = secure::string($_POST['public']) == 'public';

  $data = array(
    'fk_owner' => $_SESSION['account']['id'],
    'name' => $name,
    'ispublic' => $public
  );

  $channel->setData($data);

  if (isset($id)) {
    // Mise à jour
    if ($channel->update($infoErrors)) {
      $infoSucc = 'Mise à jour de la chaine réussie';
    }
  } else {
    // Créer
    if ($channel->create($infoErrors)) {
      $infoSucc = 'Création de la chaine réussie. <a href="profile.php">Retour à mes chaines</a>';
    }
  }
}