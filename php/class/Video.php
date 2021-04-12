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
use Exception;
use PDO;
use Verify;
use Secure;

/**
 * Video
 *
 * Cette class permet d'intéragire avec la base de données
 * pour gérer une video (édition, création, suppression).
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
      'fk_channel' => -1,
      'title' => 'no title',
      'description' => 'no description',
      'fragment' => NULL,
      'duration' => NULL,
      'miniature' => NULL,
      'isblocked' => false,
      'views' => -1,
      'evaluation' => -1
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
        return $this->data[$name];
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
    if (empty($this->data['title'])) {
      addError("Le titre de la vidéo est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['description'])) {
      addError("La description de la vidéo est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['fragment'])) {
      addError("Le fragment de la vidéo est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['duration'])) {
      addError("La durée de la vidéo est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['miniature'])) {
      addError("Aucune miniature définie", $errArray);
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
      $query = $this->bdd->prepare("INSERT INTO video (id_video, fk_chaine, intitule, description, html_fragment, duree, url_apercu, date_ajout, est_bloquee)
                                    VALUES (NULL, :fk_chaine, :intitule, :description, :html_fragment, :duree, :url_apercu, NOW(), :est_bloquee)");
      $query->bindValue(':fk_chaine', $this->data['fk_channel'], PDO::PARAM_INT);
      $query->bindValue(':intitule', $this->data['title'], PDO::PARAM_STR);
      $query->bindValue(':description', $this->data['description'], PDO::PARAM_STR);
      $query->bindValue(':html_fragment', $this->data['fragment'], PDO::PARAM_STR);
      $query->bindValue(':duree', $this->data['duration'], PDO::PARAM_STR);
      $query->bindValue(':url_apercu', $this->data['miniature'], PDO::PARAM_STR);
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
   * Permet de mettre à jour une vidéo avec les données locales.
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
      addError("L'ID de la vidéo à mettre à jour est inconnu", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("UPDATE video
                                    SET fk_chaine = :fk_chaine, intitule = :intitule, description = :description, html_fragment = :html_fragment, duree = :duree, url_apercu = :url_apercu, est_bloquee = :est_bloquee
                                    WHERE id_video = :id_video");
      $query->bindValue(':id_video', $this->data['id'], PDO::PARAM_INT);
      $query->bindValue(':fk_chaine', $this->data['fk_channel'], PDO::PARAM_INT);
      $query->bindValue(':intitule', $this->data['title'], PDO::PARAM_STR);
      $query->bindValue(':description', $this->data['description'], PDO::PARAM_STR);
      $query->bindValue(':html_fragment', $this->data['fragment'], PDO::PARAM_STR);
      $query->bindValue(':duree', $this->data['duration'], PDO::PARAM_STR);
      $query->bindValue(':url_apercu', $this->data['miniature'], PDO::PARAM_STR);
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
   * Supprimer une vidéo.
   *
   * @return      boolean True: succès <br>
   *                      False: échec.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id de la vidéo à supprimer.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function remove(&$errArray, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    if ($id < 0) {
      addError("L'ID de la vidéo à supprimer est inconnu", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("DELETE FROM video WHERE id_video = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        $query->closeCursor();
        if (!empty($this->data['miniature'])) {
          removeFile($errArray, $this->data['miniature']);
        }
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
   * Importer les données d'une vidéo présentes
   * en base de données en local.
   *
   * @return      boolean True: Importation réussie <br>
   *                      False: Échec importation.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id de la vidéo à importer.
   * @param       int $priority Niveau de priorité: <br>
   *                            0: chargement normal ; <br>
   *                            1: normal + vidéos supprimées.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function import(&$errArray, $id, $priority = 0) {
    $id = empty($id) ? $this->data['id'] : $id;
    if ($id < 0) {
      addError("L'ID de la vidéo à importer est inconnu", $errArray);
      return false;
    }
    try {
      if ($priority == 1) {
        $query = $this->bdd->prepare("SELECT *
                                      FROM video
                                      WHERE id_video = :id");
      } else {
        $query = $this->bdd->prepare("SELECT *
                                      FROM video
                                      WHERE id_video = :id AND est_bloquee = false");
      }
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Il n'existe aucune vidéo aillant l'id: $id", $errArray);
          return false;
        }
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        // set data
        $this->data['id'] = $data['id_video'];
        $this->data['fk_channel'] = $data['fk_chaine'];
        $this->data['title'] = $data['intitule'];
        $this->data['description'] = $data['description'];
        $this->data['fragment'] = $data['html_fragment'];
        $this->data['duration'] = $data['duree'];
        $this->data['miniature'] = $data['url_apercu'];
        $this->data['isblocked'] = $data['est_bloquee'];
        // views count
        $views = $this->countView($errArray);
        if ($views !== false) {
          $this->data['views'] = $views;
        } else {
          addError("Impossible de compter le nombre de vue de la vidéo", $errArray);
        }
        // evaluation value
        $evaluation = $this->countEvaluation($errArray);
        if ($evaluation !== false) {
          $this->data['evaluation'] = $evaluation;
        } else {
          addError("Impossible de récupérer la valeur des évaluations de la vidéo", $errArray);
        }
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
   * @param       int $id L'id de la chaine.
   * @param       int $priority Niveau de priorité: <br>
   *                            0: chargement normal ; <br>
   *                            1: normal + vidéos supprimées.
   * @param       int $limitoffset Tableau contenant la limit puis l'offset de
   *                               la requête select (ex: [5, 10]).
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function exportAll(&$errArray, $id, $priority = 0, $limitoffset = null) {
    if (empty($id) || $id <= -1) {
      addError("ID de la chaine invalide invalide", $errArray);
      return false;
    }
    try {
      $addToRequeste = empty($limitoffset) ? '' : secure::sql("LIMIT ".$limitoffset[0].", ".$limitoffset[1]);
      if ($priority == 1) {
        $query = $this->bdd->prepare("SELECT id_video
                                      FROM video
                                      WHERE fk_chaine = :id
                                      ORDER BY date_ajout DESC
                                      $addToRequeste");
      } else {
        $query = $this->bdd->prepare("SELECT id_video
                                      FROM video
                                      WHERE fk_chaine = :id AND est_bloquee = false
                                      ORDER BY date_ajout DESC
                                      $addToRequeste");
      }
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Cette chaine ne contient aucune vidéo", $errArray);
          return false;
        }
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $videos = array();
        foreach ($data as $value) {
          $video = new Video($this->bdd);
          $video->import($errArray, $value['id_video'], $priority);
          $videos[] = $video;
        }
        return $videos;
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
   * Ajout une vue à la vidéo.
   *
   * @return      boolean True: ajour réussi <br>
   *                      False: ajout raté.
   * @param       array $errArray Tableau d'erreurs du siteweb.
   * @param       int $idMember Id du membre qui vient de visualiser la vidéo.
   * @param       int $idVideo Id de la vidéo qui vient d'être visualisé.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function addView(&$errArray, $idMember, $idVideo = null) {
    $id = empty($idVideo) ? $this->data['id'] : $idVideo;
    try {
      $query = $this->bdd->prepare("INSERT INTO voir
                                    (id_compte, id_video, date_vue)
                                    VALUES
                                    (:id_compte, :id_video, NOW())");
      $query->bindValue('id_compte', $idMember, PDO::PARAM_INT);
      $query->bindValue(':id_video', $id, PDO::PARAM_INT);
      if ($query->execute()) {
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
   * Compte le nombre de vue sur une vidéo du siteweb.
   *
   * @return      int|boolean Le nombre de vue ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       int $idVideo L'id de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function countView(&$errArray, $idVideo = null) {
    $id = empty($idVideo) ? $this->data['id'] : $idVideo;
    try {
      $query = $this->bdd->prepare("SELECT COUNT(*) AS vues FROM voir WHERE id_video = :id_video");
      $query->bindValue(':id_video', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        return $query->fetch(PDO::FETCH_ASSOC)['vues'];
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
   * Récupérer l'évaluation d'un membre.
   *
   * @return      string|boolean Type d'évaluation d'un membre ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       int $idMember L'id du membre.
   * @param       int $idVideo L'id de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getEvaluationOfAMember(&$errArray, $idMember, $idVideo = null) {
    $id = empty($idVideo) ? $this->data['id'] : $idVideo;
    try {
      $query = $this->bdd->prepare("SELECT evaluation
                                    FROM evaluer
                                    WHERE id_compte = :id_compte AND id_video = :id_video");
      $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
      $query->bindValue(':id_video', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() > 0) {
          return $query->fetch(PDO::FETCH_ASSOC)['evaluation'];
        }
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
   * Ajouter une évaluation et ou la modifier, voir la
   * supprimer si add la même éval que celle qui existe déjà.
   *
   * @return      int|boolean Le nombre de vue ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       int $idMember L'id du membre qui veut évaluer la vidéo.
   * @param       string $choice Type d'évaluation <u>'like'</u>, <u>'unlike'</u>.
   * @param       int $idVideo L'id de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function addEvaluation(&$errArray, $idMember, $choice, $idVideo = null) {
    $id = empty($idVideo) ? $this->data['id'] : $idVideo;
    if (!verify::enum($choice, ['like','unlike'])) {
      addError("Valeur entré dans le système d'évaluation incorrect", $errArray);
      return false;
    }
    try {
      $getEval = $this->getEvaluationOfAMember($errArray, $idMember, $idVideo);
      if ($getEval) {
        if ($getEval == $choice) {
          $query = $this->bdd->prepare("DELETE FROM evaluer
                                        WHERE id_compte = :id_compte AND id_video = :id_video");
          $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
          $query->bindValue(':id_video', $id, PDO::PARAM_INT);
          if ($query->execute()) {
            $query->closeCursor();
            return true;
          } else {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          }
        } else {
          $query = $this->bdd->prepare("UPDATE evaluer
                                        SET evaluation = :evaluation
                                        WHERE id_compte = :id_compte AND id_video = :id_video");
          $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
          $query->bindValue(':id_video', $id, PDO::PARAM_INT);
          $query->bindValue(':evaluation', $choice, PDO::PARAM_STR);
          if ($query->execute()) {
            $query->closeCursor();
            return true;
          } else {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          }
        }
      } else {
        $query = $this->bdd->prepare("INSERT INTO evaluer
                                      (id_compte, id_video, evaluation)
                                      VALUES
                                      (:id_compte, :id_video, :evaluation)");
        $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
        $query->bindValue(':id_video', $id, PDO::PARAM_INT);
        $query->bindValue(':evaluation', $choice, PDO::PARAM_STR);
        if ($query->execute()) {
          $query->closeCursor();
          return true;
        } else {
          $query->closeCursor();
          addError("Erreur lors de l'exécution de la requète SQL", $errArray);
        }
      }
    } catch (Exception $e) {
      addError($e, $errArray, true);
    }
    return false;
  }

  /**
   * Génère un pourcentage avec les évaluations de la vidéo.
   *
   * @return      boolean|int Pourcentage 0 à 100% ou false si erreur.
   * @param       array $errArray Tableau d'erreurs du siteweb.
   * @param       int $idVideo Id de la vidéo dont il faut get les évaluations.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function countEvaluation(&$errArray, $idVideo = null) {
    $id = empty($idVideo) ? $this->data['id'] : $idVideo;
    try {
      $query = $this->bdd->prepare("SELECT evaluation AS type, count(evaluation) AS nombre
                                    FROM evaluer
                                    WHERE id_video = :id_video
                                    GROUP BY evaluation
                                    ORDER BY evaluation ASC");
      $query->bindValue(':id_video', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() > 0) {
          $data = $query->fetchAll(PDO::FETCH_ASSOC);
          $like = $data[0]['nombre'];
          $unlike = $data[1]['nombre'];
          return round(($like / ($like + $unlike) * 100), 0, PHP_ROUND_HALF_UP);
        } else {
          return 0;
        }
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