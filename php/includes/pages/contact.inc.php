<?php
$page = "contact"; include("core.php");

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Remplire adresse email si utilisateur connecté.
$email = isConnected() ? $_SESSION['account']['email'] : NULL;

// Envoie email
if (isset($_POST['submit'])) {
  if (reCaptchaV2($_POST['g-recaptcha-response'])) {
    $email = secure::string($_POST['email']);
    $subject = secure::string($_POST['subject']);
    $content = secure::string($_POST['content']);
    # Vérification champs
    verify::email($email, $infoErrors);
    if (empty($subject)) {
      addError("Le motif de contact est invalide", $infoErrors);
    }
    if (empty($content)) {
      addError("Le message de contact ne peut pas être vide", $infoErrors);
    }
    # Envoie
    if (empty($infoErrors)) {
      # User - meta
      $userName = isConnected() ? $_SESSION['account']['firstname'] : $email;
      # User - email
      $bodyUser = "Bonjour $userName,<br>Nous vous informons que votre demande de contact a bien été transmise à l'Administrateur de " . CONFIG['websiteName'] . ".";
      $subjectUser = "Confirmation de votre demande de contact";
      # Admin - email
      $bodyAdmin = "<b>Vous avez reçus une demande de contact</b><br><u>Email</u>: <a href='mailto:$email'>$email</a><br><u>Sujet</u>: $subject<br><u>Message</u>: $content";
      $subjectAdmin = "Demande de contact d'un membre";
      sendEmail($infoErrors, $bodyUser, $subjectUser, $email);
      if (sendEmail($infoErrors, $bodyAdmin, $subjectAdmin, CONFIG['email']['replyemail'])) {
        $infoSucc = "L'administrateur a été contacté avec succès !";
      }
    }
  } else {
    addError("Échec de la validation du reCaptcha ! Veuillez réessayer.", $infoErrors);
  }
}