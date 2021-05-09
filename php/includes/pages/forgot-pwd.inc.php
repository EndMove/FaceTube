<?php
$page = "login"; include("core.php");

// Variable d'information sur les erreurs
$infoErrors = array();
$infoSucc   = '';

// Redirige l'utilisateur si celui-ci est déjà connecté
if (isConnected()) {
  header('Location: ' . getRootUrl(true) . '/home.php');
  die();
}

// Vérifie si le mot de passe doit être reset
if (isset($_POST['submit'])) {
  $login = secure::string($_POST['login']);

  if (reCaptchaV2($_POST['g-recaptcha-response'])) {
    $member = new member\Member($bdd);

    if ($id = $member->getID($infoErrors, $login)) {
      if ($member->import($infoErrors, $id)) {
        $data = $member->getData();
        if (!$data['isblocked']) {
          $newPassword = getToken(10);
          $member->password = $newPassword;
          if ($member->update($infoErrors)) {
            // Email de notification
            $body = "Bonjour " . $data['firstname'] . ",<br>Votre mot de passe " . CONFIG['websiteName'] . " a été modifié.<br>Voici votre nouveau mot de passe : <b>" . $newPassword . "</b>";
            $subject = "Mot de passe " . CONFIG['websiteName'] . " modifié !";
            sendEmail($infoErrors, $body, $subject, $data['email']);
            $infoSucc = "Un mot de passe temporaire a été défini pour votre compte et clui-ci vous a été envoyé par email.";
          }
        } else {
          addError("Cette utilisateur est banni", $infoErrors);
        }
      } else {
        addError("Impossible de récupérer le compte", $infoErrors);
      }
    } else {
      addError("Ce compte n'existe pas", $infoErrors);
    }
  } else {
    addError("Échec de la validation du reCaptcha ! Veuillez réessayer.", $infoErrors);
  }
}