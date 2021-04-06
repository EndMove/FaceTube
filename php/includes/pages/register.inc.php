<?php
$page = "register"; include("core.php");

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Inscription
if (isset($_POST['submit'])) {
  $lastname = secure::string($_POST['lastname']);
  $firstname = secure::string($_POST['firstname']);
  $pseudonym = secure::string($_POST['pseudonym']);
  $email = secure::string($_POST['email']);
  $password = secure::string($_POST['password']);
  $repeat_password = secure::string($_POST['repeat_password']);

  if (verify::password($password, $infoErrors) && verify::passwordMatch($password, $repeat_password, $infoErrors)) {
    $data = array(
      'lastname' => $lastname,
      'firstname' => $firstname,
      'login' => $pseudonym,
      'email' => $email,
      'password' => $password
    );

    $member = new member\Member($bdd);
    $member->setData($data);

    if ($member->create($infoErrors)) {
      $infoSucc = "Votre compte à été créé avec succès. Connectez vous <a href='index.php'>ici</a>";
    }
  }
}