<?php
/**
 * dataUtils, fichier de class, fonctions statics permetant
 * la sécurisation, vérification et obtention de données
 * sur l'utilisateur du site web.
 *
 * @package     dataUtils
 *
 * @version     1.0
 *
 * @author      Jérémi Nihart <contact@endmove.eu>
 * @copyright   © 2021 EndMove, Tous droits réservés.
 *
 * @since       1.0.0
 */

namespace dataUtils;

/**
 * secure
 *
 * Permet la sécurisation des données du site web
 * données passé en GET, POST... en fonction de leurs types.
 *
 * @package     dataUtils
 *
 * @version     1.0
 * @author      Jérémi N 'EndMove'
 */
class secure {

  public static function string($txt) {
    return empty(trim($txt)) ? '' : htmlspecialchars($txt);
  }

  public static function stringComp($txt) {
    return empty(trim($txt)) ? '' : htmlentities($txt, ENT_COMPAT, 'utf-8');
  }
}

class verify {
  public static function email($txt) {
    return filter_var($txt, FILTER_VALIDATE_EMAIL) ? true : false;
  }

  public static function bool($value) {
    return is_bool($value);
  }

  public static function url($url) {
    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
  }

  public static function ip($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE) ? true : false;
  }

  public static function enum($value, $list=['0','1']) {
    foreach ($list as $content) {
      if (strval($value) == strval($content)) return true;
    }
    return false;
  }

  public static function password($password) {
    return preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $password) ? true : false;
  }

  public static function passwordMatch($password, $repeatPassword) {
    return $password === $repeatPassword;
  }
}