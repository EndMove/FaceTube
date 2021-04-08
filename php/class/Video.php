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
}