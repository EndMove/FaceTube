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

// Objet Chaine
$video = new video\Video($bdd);
$channel = new video\Channel($bdd);

// Variable par défaut
$public = false;
$name = NULL;

// Récupérer toutes les chaines
$channel->setPriority(1);
$channels = $channel->exportAll($infoErrors, $_SESSION['account']['id']);
if ($channels === false) {
  addError("Vous devez créer une chaine avant d'ajouter une video", $infoErrors);
}

// Option GET - Charger vidéo; Supprimer vidéo.
if (isset($_GET['id'])) {
  $id = secure::int($_GET['id']);
  $formAction .= "?id=$id";
  // Récupérer la vidéo la chaine
  $video->import($infoErrors, $id);
  $channel->import($infoErrors, $video->fk_channel);
  // Vérifier le propriétaire
  if ($channel->fk_owner != $_SESSION['account']['id']) {
    header('Location: ' . getRootUrl(true) . '/profile.php');
    die();
  }
  // Options
  if (isset($_GET['option'])) {
    $option = secure::string($_GET['option']);
    $formAction .="&option=$option";
    switch ($option) {
      case 'remove':
        $video->remove($infoErrors);
        header('Location: ' . getRootUrl(true) . '/channel.php?id=' . $video->fk_channel);
        die();
      default:
        addError("Option inconnue merci de vérifier votre requète HTTP", $infoErrors);
        break;
    }
  }
  $fk_channel = $video->fk_channel;
  $title = $video->title;
  $description = $video->description;
  $fragment = $video->fragment;
  $duration = $video->duration;
}

// Option POST (mettre à jour chaine || créer chaine).
if (isset($_POST['submit'])) {
  $fk_channel = secure::int($_POST['channel']);
  $title = secure::string($_POST['title']);
  $description = secure::string($_POST['description']);
  $fragment = secure::string($_POST['html_fragment']);
  $duration = secure::string($_POST['time']);

  $data = array(
    'fk_channel' => $fk_channel,
    'title' => $title,
    'description' => $description,
    'fragment' => $fragment,
    'duration' => $duration
  );

  if ($_FILES['banner']['name'] != '') {
    $file = $_FILES['banner'];
    if (isset($id)) {
      removeFile($infoErrors, $video->miniature);
    }
    if (($link = uploadFile($infoErrors, $file)) === false) {
      unset($id);
    } else $data['miniature'] = $link;
  }

  $video->setData($data);

  if (isset($id)) {
    // Mise à jour
    if ($video->update($infoErrors)) {
      $infoSucc = 'Mise à jour de la vidéo réussie !';
    }
  } else {
    // Créer
    if ($video->create($infoErrors)) {
      $infoSucc = 'Création de la vidéo réussie !';
    }
  }
  $channel->import($infoErrors, $fk_channel);
  $channel->datelastvideo = retrieveDate(null, 'Y-m-d H:i:s');
  $channel->update($infoErrors);
}