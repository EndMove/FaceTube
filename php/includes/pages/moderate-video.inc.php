<?php
$page = "account"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected() || !isAdmin()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// manage block
