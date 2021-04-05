<?php
require 'core.php';
use db\DBManager as dbm;
use dataUtils\secure as secure;
use dataUtils\verify;

$errorArray = array();  # Tableau d'erreurs

# test connexion BDD
$bdd = dbm::connect($errorArray);
if ($bdd) {
  echo "connexion ok";
} else {
  echo "connexion pas ok du tout";
  var_dump($errorArray);
}

# test fonction dataUtils
$txt01 = "\njdjhz<?php jdjdhd ?>";
echo '<br>' . secure::string($txt01);
echo '<br>' . secure::stringComp($txt01);
echo '<br>' . secure::string("   ") . 'jddjjd';

var_dump(verify::email(NULL));

# Simulation inscription
$member = new member\Member($bdd);