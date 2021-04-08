<?php
require 'core.php';
use db\DBManager as dbm;

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
$member->auth("superjeremi1302@gmail.com", "End42_", $errorArray);

# verif
var_dump(verify::password("salutP151", $errorArray));
var_dump(verify::passwordMatch("salutP151", "salutP51", $errorArray));
var_dump($errorArray);

# secure
echo secure::string("Jérémi Nihart");

if (0) {
  echo "wowow";
} else {
  echo "nndndndn";
}

//if (sendEmail($errorArray, "Je suis le contenu <br> de l'email mdr", "Un nouvel email", "superjeremi1302@gmail.com")) {
//  echo "<b>EMAIL HAS BEEN SENT</b>";
//  var_dump($errorArray);
//} else {
//  echo "<b>EMAIL COULD NOT BE SEND</b>";
//  var_dump($errorArray);
//}

var_dump(retrieveDate());