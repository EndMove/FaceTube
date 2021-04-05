<?php
require 'php/class/DBManager.php';
use db\DBManager as dbm;

$errorArray = array();

$bdd = dbm::connect($errorArray);
if ($bdd) {
  echo "connexion ok";
} else {
  echo "connexion pas ok du tout";
}