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

// Objets
$channel = new channel\Channel($bdd);
$video = new video\Video($bdd);
$member = new member\Member($bdd);

if (isAdmin()) {
  $video->setPriority(1);
  $channel->setPriority(2);
}

// Récupération des 3 dernières vidéos de chaque chaine des amis
$homeData = array();
$friendsList = $member->getFriendList($infoErrors, $_SESSION['account']['id']);
if ($friendsList != 'none') {
  foreach ($friendsList as $fl) {
    if ($channelsList = $channel->exportAll($infoErrors, $fl['id'])) {
      foreach ($channelsList as $cl) {
        $vi = array();
        if ($videosList = $video->exportAll($infoErrors, $cl->id, [0, 3])) {
          foreach ($videosList as $vl) {
            $video->import($infoErrors, $vl->id);
            $vi[] = $video->getData();
          }
        }
        $channel->import($infoErrors, $cl->id);
        $ch = $channel->getData();
        $homeData[] = array(
          'ch' => $ch,
          'vi' => $vi
        );
      }
    }
  }
}
if (empty($homeData)) {
  header('Location: ' . getRootUrl(true) . '/profile.php');
  die();
}