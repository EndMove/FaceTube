<?php
/**
 * dataFunctions est un fichier de class, fonctions statics permetant
 * la sécurisation, vérification et obtention de données
 * sur l'utilisateur du site web.
 *
 * @version     1.1
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

  /**
   * Protéger une valeur entière ou décimale en
   * transforment les caractères spéciaux.
   *
   * @return      int Un integer désamorcé en <u>-1</u>
   *                  si le paramètre n'étais ni un float ni un int.
   * @param       int|string $int Valeur flottant ou entièrer.
   *
   * @since 1.0
   *
   * @see         secure::string()
   * @author      Jérémi N 'EndMove'
   */
  static function int($int) {
    $int = secure::string($int);
    if (is_numeric($int)) {
      if (preg_match("/^[0-9]+[.0-9]+$/", $int)) {
        return floatval($int);
      } else {
        return intval($int);
      }
    }
    return -1;
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

  /**
   * Vérifie si il y a eu des erreurs durant l'upload du fichier.
   *
   * @return      boolean True: Aucune erreur à déplorer <br>
   *                      False: Une erreur à déplorer.
   * @param       int $file Variable d'un fichier uploadé.<br>
   *                             <b>$_FILE['myFile']</b>
   * @param       array $errArray Tableau d'erreurs du site web.
   *
   * @since 1.1
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function fileError($file, &$errArray) {
    if ($file['error'] != 0) {
      switch ($file['error']) {
        case UPLOAD_ERR_INI_SIZE:
          addError("La taille maximal d'upload de PHP a été dépassé", $errArray);
          break;
        case UPLOAD_ERR_PARTIAL:
          addError("L'upload du fichier est incomplet", $errArray);
          break;
        case UPLOAD_ERR_NO_FILE:
          addError("Aucun fichier n'a été spécifié", $errArray);
          break;
        case UPLOAD_ERR_NO_TMP_DIR:
          addError("Le fichier d'upload de PHP n'a pas été trouvé", $errArray);
          break;
        case UPLOAD_ERR_CANT_WRITE:
          addError("PHP n'arrive pas à écrire le fichier sur le disque", $errArray);
          break;
        case UPLOAD_ERR_FORM_SIZE:
          addError("Le taille maximal spécifié dans le formulaire a été dépassé", $errArray);
          break;
        default:
          addError("Erreur de fichier", $errArray);
      }
      return false;
    }
    return true;
  }

  /**
   * Vérifie si l'extension et le type de fichier sont acceptés.
   *
   * @return      boolean True: Path autorisé <br>
   *                      False: Path non autorisé.
   * @param       int $file Variable d'un fichier uploadé.<br>
   *                             <b>$_FILE['myFile']</b>
   * @param       array $errArray Tableau d'erreurs du site web.
   *
   * @since 1.1
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function filePath($file, &$errArray) {
    $path = getPath($file['name']);
    if (key_exists($path, CONFIG['file']['pathallowed'])) {
      if (in_array($file['type'], CONFIG['file']['pathallowed'])){
        return true;
      } else addError("Type de fichier non autorisé", $errArray);
    } else addError("Extension de fichier non autorisé", $errArray);
    return false;
  }

  /**
   * Vérifie si le fichier n'est pas trop valumineux.
   *
   * @return      boolean True: Le fichier à une taille valide <br>
   *                      False: Le fichier à une taille invalide.
   * @param       int $file Variable d'un fichier uploadé.<br>
   *                             <b>$_FILE['myFile']</b>
   * @param       array $errArray Tableau d'erreurs du site web.
   *
   * @since 1.1
   *
   * @see         addError()
   * @author      Jérémi N 'EndMove'
   */
  public static function fileSize($file, &$errArray) {
    if ($file['size'] <= CONFIG['file']['maximumsize']) {
      return true;
    }
    addError("Le fichier est trop volumineux", $errArray);
    return false;
  }
}