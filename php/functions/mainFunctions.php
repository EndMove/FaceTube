<?php

/**
 * Permet d'ajouter des erreurs au tableau d'erreurs.
 *
 * @return      array Le tableau d'erreur
 * @param       object|string $e Object d'exception, d'erreur ou message d'erreur.
 * @param       array $errArray Tableau d'erreur déjà existant.
 * @param       boolean $hide Ajouter l'erreur dans un sous tableau 'hide' True/False.
 *
 * @since 1.0
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
 * @since 1.0
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
 * @param       string $string Afficher le contenu du sous tableau 'hide' True/False.
 *
 * @since 1.0
 *
 * @author      Jérémi N 'EndMove'
 */
function showSuccess($message) {
  if (!empty($message)) echo '<div class="info-box success"><p>' . $message . '</p></div>';
}

/**
 * Permet de fortifier et de hashé un mot de passe.
 *
 * @return      string Mot de passe fortifié et hashé.
 * @param       string $string Mot de passe à traiter.
 *
 * @since 1.0
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
 * @since 1.0
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

function isConnected() {
  return isset($_SESSION['account']);
}

function getRootUrl($configFolder = false) {
  $ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
  $ssl .= '://' . $_SERVER['HTTP_HOST'];
  return $configFolder ? $ssl . CONFIG['websiteFolder'] : $ssl;
}

function getRedirectUrl($tag = null) {
  $link = getRootUrl(true) . '/index.php?redirect=';
  $link .= urlencode(getRootUrl() . $_SERVER['REQUEST_URI']);
  if (!empty($tag)) $link .= $tag;
  return $link;
}