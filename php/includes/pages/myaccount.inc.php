<?php
$page = "account"; include("core.php");

// Vérifier si le membre est connecté
if (!isConnected()) {
  header('Location: '.getRedirectUrl());
  die();
}

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Objet membre
$member = new member\Member($bdd);

// Form action
$formAction = htmlspecialchars($_SERVER["PHP_SELF"]);

// Mise à jour informations compte
if (isset($_POST['submit'])) {
  $lastname = secure::string($_POST['lastname']);
  $firstname = secure::string($_POST['firstname']);
  $pseudonym = secure::string($_POST['pseudonym']);
  $password = secure::string($_POST['password']);
  $repeat_password = secure::string($_POST['repeat_password']);
  $status = true;

  $data = array(
    'lastname' => $lastname,
    'firstname' => $firstname,
    'login' => $pseudonym
  );

  if (!empty($password)) {
    if (verify::password($password, $infoErrors) && verify::passwordMatch($password, $repeat_password, $infoErrors)) {
      $data['password'] = $password;
    } else {
      $status = false;
    }
  }

  if ($status) {
    if ($member->import($infoErrors, $_SESSION['account']['id'])) {
      $member->setData($data);
      if ($member->update($infoErrors)) {
        $_SESSION['account'] = $member->getData();
        // Message succès
        $infoSucc = "Les informations de votre compte on été mises à jour";
        // Email pour mot de passe modifié
        if (!empty($password)) {
          $body = "Bonjour $firstname,<br>Nous tenons à vous informer que votre mot de passe a été modifier le " . retrieveDate() . ".";
          $subject = "Votre mot de passe a été modifié";
          sendEmail($infoErrors, $body, $subject, $_SESSION['account']['email']);
        }
      }
    }
  }
}

// supression compte
if (isset($_GET['rc'])) {
  if ($member->import($infoErrors, $_SESSION['account']['id'])) {
    if ($member->remove($infoErrors)) {
      header('Location: ' . getRootUrl(true) . '/logout.php?rc=true');
      die();
    }
  }
}