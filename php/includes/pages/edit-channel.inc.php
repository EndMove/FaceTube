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

// Form action
$formAction = htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);

// Objet Chaine
$channel = new channel\Channel($bdd);
$video = new video\Video($bdd);

// Variable par défaut
$public = false;
$name = NULL;

// Option GET (charger chaine existante).
if (isset($_GET['id'])) {
  $id = secure::int($_GET['id']);
  // Récupérer chaine et vérifier qu'on est propriétaire
  $channel->setPriority(1);
  $channel->import($infoErrors, $id);
  if ($channel->fk_owner != $_SESSION['account']['id']) {
    header('Location: ' . getRootUrl(true) . '/profile.php');
    die();
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
      header('Location: ' . getRootUrl(true) . '/profile.php?msg=cc');
      die();
    }
  }
}

if (isset($_GET['rc']) && isset($id)) {
  $videos = $video->exportAll($infoErrors, $id);
  if ($videos !== false) {
    addError('Impossible de supprimer cette chaîne car elle contien encore des vidéos', $infoErrors);
  } else {
    $video->setPriority(1);
    $videos = $video->exportAll($infoErrors, $id);
    if ($videos !== false) {
      foreach ($videos as $vi) {
        $vi->remove($infoErrors);
      }
    }
    $channel->remove($infoErrors);
    header('Location: ' . getRootUrl(true) . '/profile.php?msg=rc');
    die();
  }
}