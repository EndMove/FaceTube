<?php
/**
 * Channel, Permet de gérer les chaines du membre.
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
use Exception;
use PDO;
use Verify;

/**
 * Channel
 *
 * Cette class permet de gérer les chaines d'un membre
 * en interagissant directement avec les base de données.
 *
 * @package     video
 *
 * @version     1.0
 * @see         addError()
 * @author      Jérémi N 'EndMove'
 */
class Channel {
  private $bdd;
  private $data;

  const CANT_SET = array('bdd', 'id', 'fk_owner');
  const CANT_GET = array('bdd');

  public function __construct($bdd) {
    $this->bdd = !empty($bdd) ? $bdd : NULL;
    $this->data = array(
      'id' => -1,
      'fk_owner' => -1,
      'name' => 'no name',
      'ispublic',
      'evaluation' => 0,
      'datelastvideo' => NULL,
      'isblocked' => 0
    );
  }

  /**
   * Récupérer une donnée local de la chaine.
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
   * Éditer une donnée de de la chaine localement.
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
   * Éditer des données locales de la chaine.
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
   * Récupérer les données locales de la chaine.
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
   * Permet de vérifier si toutes les données
   * locales respectent les attentes.
   *
   * @return      boolean True: données valides <br>
   *                      False: donnée(s) invalide(s)
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @see         verify
   * @author      Jérémi N 'EndMove'
   */
  private function check(&$errArray) {
    $status = true;
    if (empty($this->data['name'])) {
      addError("Le nom de la chaine est vide", $errArray);
      $status = false;
    }
    if (!verify::bool($this->data['ispublic'], $errArray)) {
      $status = false;
    }
    if (!is_numeric($this->data['evaluation'])) {
      addError("La valeur de l'évaluation n'est pas numérique", $errArray);
      $status = false;
    }
    if (!verify::bool($this->data['isblocked'], $errArray)) {
      $status = false;
    }
    return $status;
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
    try {
      $query = $this->bdd->prepare("INSERT INTO chaine (id_chaine, fk_compte, nom, est_publique, evaluation, date_derniere_video, est_bloquee)
                                    VALUES (NULL, :fk_compte, :nom, :est_publique, :evaluation, :date_derniere_video, :est_bloquee)");
      $query->bindValue(':fk_compte', $this->data['fk_owner'], PDO::PARAM_INT);
      $query->bindValue(':nom', $this->data['name'], PDO::PARAM_STR);
      $query->bindValue(':est_publique', $this->data['ispublic'], PDO::PARAM_BOOL);
      $query->bindValue(':evaluation', $this->data['evaluation'], PDO::PARAM_INT);
      $query->bindValue(':date_derniere_video', $this->data['datelastvideo'], PDO::PARAM_STR);
      $query->bindValue(':est_bloquee', $this->data['isblocked'], PDO::PARAM_BOOL);
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

  /**
   * Permet de mettre à jour une chaine avec les données locales.
   *
   * @return      boolean True: mise à jour réussie <br>
   *                      False: échec mise à jour.
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function update(&$errArray) {
    if (!$this->check($errArray)) return false;
    if ($this->data['id'] < 0) {
      addError("L'ID de la chaine à mettre à jour est inconnu", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("UPDATE chaine
                                    SET nom = :nom, est_publique = :est_publique, evaluation = :evaluation, date_derniere_video = :date_derniere_video, est_bloquee = :est_bloquee
                                    WHERE id_chaine = :id_chaine");
      $query->bindValue(':id_chaine', $this->data['id'], PDO::PARAM_INT);
      $query->bindValue(':nom', $this->data['name'], PDO::PARAM_STR);
      $query->bindValue(':est_publique', $this->data['ispublic'], PDO::PARAM_BOOL);
      $query->bindValue(':evaluation', $this->data['evaluation'], PDO::PARAM_INT);
      $query->bindValue(':date_derniere_video', $this->data['datelastvideo'], PDO::PARAM_STR);
      $query->bindValue(':est_bloquee', $this->data['isblocked'], PDO::PARAM_BOOL);
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

  /**
   * Supprimer une chaine et toutes les vidéos affiliées.
   *
   * @return      boolean True: succès <br>
   *                      False: échec.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id de la chaine à supprimer.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function remove(&$errArray, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    if ($id < 0) {
      addError("L'ID de la chaine à supprimer est inconnu", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("DELETE FROM chaine WHERE id_chaine = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
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

  /**
   * Importer les données présentes en base de données en local.
   *
   * @return      boolean True: Importation réussie <br>
   *                      False: Échec importation.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id de la chaine.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function import(&$errArray, $id) {
    $id = empty($id) ? $this->data['id'] : $id;
    if ($id < 0) {
      addError("L'ID de la chaine à importer est inconnu", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("SELECT * FROM chaine WHERE id_chaine = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Il n'existe aucune chaine aillant l'id: $id", $errArray);
          return false;
        }
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $this->data['id'] = $data['id_chaine'];
        $this->data['fk_owner'] = $data['fk_compte'];
        $this->data['name'] = $data['nom'];
        $this->data['ispublic'] = $data['est_publique'];
        $this->data['evaluation'] = $data['evaluation'];
        $this->data['datelastvideo'] = $data['date_derniere_video'];
        $this->data['isblocked'] = $data['est_bloquee'];
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

  /**
   * Exporter les donnes présentes en base de
   * donnée sur forme d'un tableau d'objet.
   *
   * @return      array|boolean Tableau d'objet: Exportation réussie <br>
   *                            False: Échec exportation.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id du member propriétaire de la chaine.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function exportAll(&$errArray, $id) {
    if (empty($id) || $id <= -1) {
      addError("ID du compte membre invalide", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("SELECT id_chaine FROM chaine WHERE fk_compte = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Il n'existe aucune chaine aillant l'id: $id", $errArray);
          return false;
        }
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $channels = array();
        foreach ($data as $value) {
          $channel = new Channel($this->bdd);
          $channel->import($errArray, $value['id_chaine']);
          $channels[] = $channel;
        }
        return $channels;
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