<?php
require 'core.php';
// Test trucs d'amis

$member = new member\Member($bdd);


echo "TEST METHOD: getFreindRequestsReceived<br>";
$test = $member->getFriendRequestsReceived($errArray, 6);
if ($test) {
  if (is_array($test)) {
    echo "Un SUCCES<br>";
  } else {
    echo "Un SUCCES mais aucun résultat :o <br>";
  }
  var_dump($test);
} else {echo "Une ERREUR<br>";}


echo "TEST METHOD: getFreindRequestsSent<br>";
$test = $member->getFriendRequestsSent($errArray, 5);
if ($test) {
  if (is_array($test)) {
    echo "Un SUCCES<br>";
  } else {
    echo "Un SUCCES mais aucun résultat :o <br>";
  }
  var_dump($test);
} else {echo "Une ERREUR<br>";}


echo "TEST METHOD: getFreindList<br>";
$test = $member->getFriendList($errArray, 6);
if ($test) {
  if (is_array($test)) {
    echo "Un SUCCES<br>";
  } else {
    echo "Un SUCCES mais aucun résultat :o <br>";
  }
  var_dump($test);
} else {echo "Une ERREUR<br>";}


var_dump($member->updateFriend($errArray, 5, 5, 'add'));

var_dump($member->getID($errArray, 'superjeremi1302@gmail.com'));
var_dump($member->getID($errArray, 'dnskdn'));

var_dump($errArray);
