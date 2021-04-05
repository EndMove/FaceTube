<?php


namespace db;
require ROOT . '/php/config/dbSecret.php';
use PDO;
use PDOException;

/**
 * DBManager
 *
 * Gestionaire des object PDO de connexion à la base
 * de donnée. Connecteur/Déconnecteur.
 *
 * @package     db
 *
 * @version     1.0
 * @author      Jérémi N 'EndMove'
 */
class DBManager {
  /**
   * Établit une connexion avec la base de données.
   *
   * @return      PDO|false Objet PDO prêt à exécuter des requètes.
   * @param       array $errArray Tableau pour gérer les erreurs.
   * @param       string $dbName Nom de la table en base de données.
   * @throws      PDOException Gestion des erreurs PDO à renvoyé en paramètre.
   *
   * @since 1.0
   *
   * @see         PDO()
   * @author      Jérémi N 'EndMove'
   */
  public static function connect(&$errArray, $dbName = dbNAME) {
    try {
      $bdd = new PDO("mysql:host=".dbHOST.";port=".dbPORT.";dbname=".$dbName.";charset=".dbCHAR, dbUSER, dbPASS);
      $bdd->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $bdd;
    } Catch (PDOException $e) {
      addError($e, $errArray);
      return false;
    }
  }

  /**
   * Null la connexion à la base de données (équivalent à la déstruction de l'objet).
   *
   * @param       PDO $bdd Objet PDO.
   *
   * @since 1.0
   *
   * @see         PDO()
   * @author      Jérémi N 'EndMove'
   */
  public static function disconnect(&$bdd) {
    $bdd = null;
  }
}