<?php
/**
 * Video, contien la class de gestion des vidéos du site web
 *
 * @package     video
 *
 * @version     1.0
 *
 * @author      Jérémi Nihart <contact@endmove.eu>
 * @copyright   © 2021 EndMove, Tous droits réservés.
 *
 * @since       1.0.0
 */

namespace video;

/**
 * Video
 *
 * Cette class permet d'intéragire avec la base de données
 * pour gérer un video (édition, création, suppression).
 *
 * @package     video
 *
 * @version     1.0
 * @see         addError()
 * @author      Jérémi N 'EndMove'
 */
class Video {
  private $bdd;
  private $data;

  const CANT_SET = array('bdd', 'id');
  const CANT_GET = array('bdd');

  public function __construct($bdd) {
    $this->bdd = !empty($bdd) ? $bdd : NULL;
    $this->data = array(
      'id' => -1,
      'title' => 'no title',
      'description' => 'no description',
      'fragment' => NULL,
      'duration' => NULL,
      'miniature' => NULL,
      'isblocked' => false
    );
  }

  /**
   * Récupérer une donnée local de la vidéo.
   *
   * @return      string Contenu la donnée demandé.
   * @param       string $name Nom de la donnée souhaité.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function __get($name) {
    if (!in_array($name, self::CANT_GET)) {
      if (array_key_exists($name, $this->data)) {
        return empty($this->data[$name]) ? 'No value defined yet' : $this->data[$name];
      }
    }
    return 'Get request has been rejected';
  }

  /**
   * Éditer une donnée de de la vidéo en local.
   * Voir {@see update()} pour mettre à jour en base de données.
   *
   * @param       string $name Nom de la donnée à modifier.
   * @param       string|boolean $value Nouvelle valeur de la donnée.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function __set($name, $value) {
    if (!in_array($name, self::CANT_SET)) {
      if (array_key_exists($name, $this->data)) {
        $this->data[$name] = $value;
      }
    }
  }

  /**
   * Éditer des données locales de la vidéo.
   * Voir {@see update()} pour mettre à jour en base de données.
   *
   * @param       array $dataArray Tableau de données :
   *                               array('title' => 'Un Titre', ...);
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function setData($dataArray) {
    foreach ($dataArray as $name => $value) {
      if (!in_array($name, self::CANT_SET)) {
        $this->data[$name] = $value;
      }
    }
  }

  /**
   * Récupérer les données locales de la vidéo.
   *
   * @return      array Tableau de données de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getData() {
    $data = array();
    foreach ($this->data as $name => $value) {
      if (!in_array($name, self::CANT_GET)) {
        $data[$name] = $value;
      }
    }
    return $data;
  }


  /**
   * Permet de créer un nouvelle vidéo en fonction
   * des valeurs définie via {@see setData()} ou manuellement
   * <code>$membre->title = 'Un titre'</code>
   *
   * @return      boolean True: création réussie <br>
   *                      False: échec création.
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function create(&$errArray) {
    if (!$this->check($errArray)) return false;
    if ($this->used('email', $errArray)) {
      addError("Un compte avec cette adresse email exist déjà", $errArray);
      return false;
    } else if ($this->used('login', $errArray)) {
      addError("Un compte avec ce login exist déjà", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("INSERT INTO compte (id_compte, nom, prenom, login, couriel, mot_de_passe, est_bloque)
                                    VALUES (NULL, :nom, :prenom, :login, :couriel, :mot_de_passe, :est_bloque)");
      $query->bindValue(':nom', $this->data['lastname'], PDO::PARAM_STR);
      $query->bindValue(':prenom', $this->data['firstname'], PDO::PARAM_STR);
      $query->bindValue(':login', $this->data['login'], PDO::PARAM_STR);
      $query->bindValue(':couriel', $this->data['email'], PDO::PARAM_STR);
      $query->bindValue(':mot_de_passe', $this->data['password'], PDO::PARAM_STR);
      $query->bindValue(':est_bloque', $this->data['isblocked'], PDO::PARAM_BOOL);
      if ($query->execute()) {
        $query->closeCursor();
        return true;
      } else {
        $query->closeCursor();
        addError("Erreur lors de l'exécution de la requète SQL", $errArray);
      }
    } catch (Exception $e) {
      addError($e, $errArray, true);
    }
    return false;
  }
}