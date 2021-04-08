<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Permet d'ajouter des erreurs au tableau d'erreurs.
 *
 * @return      array Le tableau d'erreur
 * @param       object|string $e Object d'exception, d'erreur ou message d'erreur.
 * @param       array $errArray Tableau d'erreur déjà existant.
 * @param       boolean $hide Ajouter l'erreur dans un sous tableau 'hide' True/False.
 *
 * @author      Jérémi N 'EndMove'
 */
function addError($e, &$errArray = array(), $hide = false) {
  if (is_object($e)) {
    $error = array(
      'object' => true,
      'message' => $e->getMessage(),
      'file' => $e->getFile(),
      'line' => $e->getLine(),
      'code' => $e->getCode()
    );
  } else {
    $error = array(
      'object' => false,
      'message' => $e
    );
  }
  if ($hide) $errArray['hide'][] = $error;
  else $errArray[] = $error;
  return $errArray;
}

/**
 * Permet d'afficher les erreurs du tableau d'erreurs.
 *
 * @param       array $errArray Tableau d'erreur déjà existant.
 * @param       boolean $hide Afficher le contenu du sous tableau 'hide' True/False.
 *
 * @author      Jérémi N 'EndMove'
 */
function showError($errArray, $hide = false) {
  $workArray = ($hide) ? $errArray['hide'] : $errArray;
  if (isset($workArray['hide'])) unset($workArray['hide']);
  $sizeArray = count($workArray);
  if ($sizeArray > 0) {
    $message = '<div class="info-box error"><p>Oupss, une ou plusieurs erreur(s) sont survenue(s) :</p><ul>';
    for ($i=0; $i < $sizeArray; $i++) {
      $err = $workArray[$i];
      if ($err['object']) {
        $message .= '<li>' . 'MSG:'.$err['message'] . '; FILE:'.$err['file'] . '; LINE:'.$err['line'] . '</li>';
      } else {
        $message .= '<li>' . $err['message'] . '</li>';
      }
    }
    $message .= '</ul></div>';
    echo $message;
  }
}

/**
 * Permet d'afficher un message de succès.
 *
 * @param       string $message Afficher le contenu du message sous forme de success box.
 *
 * @author      Jérémi N 'EndMove'
 */
function showSuccess($message) {
  if (!empty($message)) echo '<div class="info-box success"><p>' . $message . '</p></div>';
}

/**
 * Permet d'afficher un message d'information.
 *
 * @param       string $message Afficher le contenu du message sous forme d'info box.
 *
 * @author      Jérémi N 'EndMove'
 */
function showInfo($message) {
  if (!empty($message)) echo '<div class="info-box info"><p>' . $message . '</p></div>';
}

/**
 * Permet de fortifier et de hashé un mot de passe.
 *
 * @return      string Mot de passe fortifié et hashé.
 * @param       string $string Mot de passe à traiter.
 *
 * @see         md5()
 * @see         sha1()
 * @author      Jérémi N 'EndMove'
 */
function hashPassword($string) {
  return md5(sha1('!Face' . $string . 'Tube_'));
}

/**
 * Permet de supprimer les accents d'une chaine de caractères.
 *
 * @return      string Chaine avec les caractères accentués transformé en simple caractères.
 * @param       string $string Chaine de caractères accentués.
 *
 * @author      Jérémi N 'EndMove'
 */
function removeAccents($string) {
  $accents = array('a' => array('à', 'ã', 'á', 'â'),
    'e' => array('é', 'è', 'ê', 'ë'),
    'i' => array('î', 'ï'),
    'u' => array('ù', 'ü', 'û'),
    'o' => array('ô', 'ö'));
  foreach ($accents as $key => $value) {
    for ($i = 0; $i < count($value); $i++) {
      $string = str_replace($value[$i], $key, $string);
    }
  }
  return $string;
}

/**
 * Vérifier si l'utilisateur est connecté ou pas.
 *
 * @return      boolean True/False
 *
 * @author      Jérémi N 'EndMove'
 */
function isConnected() {
  return isset($_SESSION['account']);
}

/**
 * Renvoie le domaine du site web avec ou sans le dossier d'installation
 * ex: "http://endmove.eu" ou "http://endmove.eu/HELMo/FaceTube".
 *
 * @return      string Lien: "http://endmove.eu/HELMo/FaceTube".
 * @param       boolean $configFolder True: avec le dossier<br>
 *                                    False: sans le dossier.
 *
 * @author      Jérémi N 'EndMove'
 */
function getRootUrl($configFolder = false) {
  $ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
  $ssl .= '://' . $_SERVER['HTTP_HOST'];
  return $configFolder ? $ssl . CONFIG['websiteFolder'] : $ssl;
}

/**
 * Craie un lien de redirection (pour quand l'utilisateur n'est pas connecté)
 *
 * @return      string Lien de redirection "http://endmove.eu?redirect=ma_page.php".
 * @param       string $tag Tag HTML éventuel "#shopp", ...
 *
 * @see         getRootUrl()
 * @author      Jérémi N 'EndMove'
 */
function getRedirectUrl($tag = null) {
  $link = getRootUrl(true) . '/index.php?redirect=';
  $link .= urlencode(getRootUrl() . $_SERVER['REQUEST_URI']);
  if (!empty($tag)) $link .= $tag;
  return $link;
}

/**
 * Permet d'envoyer un email en utilisant PHPMailer avec
 * ou sans utiliser un server SMTP voir la configuration du site web.
 *
 * @return      boolean True: Email envoyé<br>
 *                      False: Email non envoyé.
 * @param       array $errArray Tableau d'erreurs du site web.
 * @param       string $body Corp de l'email à envoyer.
 * @param       string $subject Sujet de l'email.
 * @param       string $to Destinataire de l'email.
 * @param       array $attachment Pièce jointe :<br>
 *                                array('path' => /img/nice.png, 'name' => nice.png);
 *
 * @see         PHPMailer()
 * @see         PHPMailer
 * @see         SMTP
 * @see         Exception
 * @author      Jérémi N 'EndMove'
 */
function sendEmail(&$errArray, $body, $subject, $to, $attachment = NULL) {
  $mail = new PHPMailer();
  try {
    $mail->CharSet = CONFIG['email']['charset'];
    if (CONFIG['email']['smtpenabled']) {
      if (CONFIG['email']['smtpdebug']) {
        $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
      }
      $mail->isSMTP();
      $mail->Host         = CONFIG['email']['smtphost'];
      $mail->SMTPAuth     = CONFIG['email']['smtpauthentication'];
      $mail->Username     = CONFIG['email']['smtpusername'];
      $mail->Password     = CONFIG['email']['smtppassword'];
      $mail->SMTPSecure   = CONFIG['email']['smtpencryption'];
      $mail->Port         = CONFIG['email']['smtpport'];
    }
    $mail->setFrom(CONFIG['email']['senderemail'], CONFIG['email']['sendername']);
    $mail->addReplyTo(CONFIG['email']['replyemail'], CONFIG['email']['replyname']);
    $mail->addAddress($to);
    if (isset($attachment)) {
      $mail->addAttachment($attachment['path'], $attachment['name']);
    }
    $mail->isHTML(true);
    $mail->Subject        = $subject;
    $mail->Body           = $body;
    if ($mail->send()) {
      return true;
    }
  } catch (Exception $e) {
    addError($e, $errArray, true);
  }
  addError("Erreur lors de l'envoie de l'email", $errArray);
  return false;
}

/**
 * Obtenir une date formater.
 *
 * @return      string La date utilisant le format et timespan renseigné.
 * @param       int $timespan Timespan à utiliser pour le formatage de la date.
 * @param       string $format Format personsalisé éventuel.
 *
 * @author      Jérémi N 'EndMove'
 */
function retrieveDate($timespan = null, $format = null) {
  $format = empty($format) ? CONFIG['websiteDateformat'] : $format;
  return empty($timespan) ? date($format) : date($format, $timespan);
}