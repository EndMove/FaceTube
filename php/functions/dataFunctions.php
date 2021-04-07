<?php
/**
 * dataFunctions est un fichier de class, fonctions statics permetant
 * la sécurisation, vérification et obtention de données
 * sur l'utilisateur du site web.
 *
 * @version     1.0
 *
 * @author      Jérémi Nihart <contact@endmove.eu>
 * @copyright   © 2021 EndMove, Tous droits réservés.
 *
 * @since       1.0.0
 */


/**
 * secure
 *
 * Permet la sécurisation des données du site web
 * données passé en GET, POST... en fonction de leurs types.
 *
 * @version     1.0
 * @author      Jérémi N 'EndMove'
 */
class secure {
  /**
   * Protéger une chaine de caractère en transforment les caractères spéciaux.
   *
   * @return      string Chaine de caractères désamorcés.
   * @param       string $txt Chaine de caractères à désamorcer.
   *
   * @since 1.0
   *
   * @see         trim()
   * @see         htmlspecialchars()
   * @author      Jérémi N 'EndMove'
   */
  public static function string($txt) {
    return empty(trim($txt)) ? '' : htmlspecialchars(trim($txt));
  }

  /**
   * Protéger une chaine de caractère en transforment les caractères spéciaux.
   * <b>Protection avancé, pour données très sensibles</b>
   *
   * @return      string Chaine de caractères désamorcés.
   * @param       string $txt Chaine de caractères à désamorcer.
   *
   * @since 1.0
   *
   * @see         trim()
   * @see         htmlentities()
   * @author      Jérémi N 'EndMove'
   */
  public static function stringComp($txt) {
    return empty(trim($txt)) ? '' : htmlentities(trim($txt), ENT_COMPAT, 'utf-8');
  }
}

/**
 * Verify
 *
 * Permet de vérifier si les données du site web
 * correspondent aux attentes.
 *
 * @version     1.0
 * @author      Jérémi N 'EndMove'
 */
class verify {
  /**
   * Vérifie si une adresse email est valide.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string $txt Valeur à vérifier.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function email($txt, &$errArray = null) {
    if (filter_var($txt, FILTER_VALIDATE_EMAIL)) return true;
    addError("L'adresse email n'est pas valide", $errArray);
    return false;
  }

  /**
   * Vérifie si un boolean est valide.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       boolean $value Valeur à vérifier.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function bool($value, &$errArray = null) {
    if (is_bool($value) || self::enum($value)) return true;
    addError("La valeur boolean n'est pas valide", $errArray);
    return false;
  }

  /**
   * Vérifie si une URL est valide.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string $url Valeur à vérifier.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function url($url, &$errArray = null) {
    if (filter_var($url, FILTER_VALIDATE_URL)) return true;
    addError("L'URL renseigné n'est pas valide", $errArray);
    return false;
  }

  /**
   * Vérifie si une ip est valide.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string $ip Valeur à vérifier.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function ip($ip, &$errArray = null) {
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) return true;
    addError("L'adresse IP n'est pas valide", $errArray);
    return false;
  }

  /**
   * Vérifie si une valeur est bien présente dans une énumération.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string|int|bool|array $value Value Valeur à vérifier.
   * @param       array $list List des valeurs autorisées.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function enum($value, $list = ['0','1'], &$errArray = null) {
    foreach ($list as $content) {
      if (strval($value) == strval($content)) return true;
    }
    addError("La valeur de l'ENUM n'est pas valide", $errArray);
    return false;
  }

  /**
   * Vérifie si un mot de passe est assez fort.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string $password Valeur à vérifier.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function password($password, &$errArray = null) {
    if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $password)) return true;
    addError("Le mot de passe n'est pas assez fort", $errArray);
    return false;
  }

  /**
   * Vérifie si deux mot de passe correspondent.
   *
   * @return      boolean True: donnée valide <br>
   *                      False: donnée invalide.
   * @param       string $password Valeur N°1 à comparé.
   * @param       string $repeatPassword Valeur N°2 à comparé.
   * @param       array $errArray Tableau d'erreurs pour les gérer.
   *
   * @since 1.0
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function passwordMatch($password, $repeatPassword, &$errArray = null) {
    if ($password === $repeatPassword) return true;
    addError("Les mots de passe ne correspondents pas", $errArray);
    return false;
  }
}