<?php
/**
 * Video, contien la class de gestion des vidéos du site web
 *
 * @package     video
 *
 * @version     1.2
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
  private $priority;
  public $evaluationObject;
  public $commentObject;

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
      'evaluation' => -1,
      'comment' => -1
    );
    $this->priority = 0;
    $this->evaluationObject = NULL;
    $this->commentObject = NULL;
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
    switch ($name) {
      case 'evaluationObject':
        return $this->evaluationObject;
      case 'commentObject':
        return $this->commentObject;
      default:
        if (!in_array($name, self::CANT_GET)) {
          if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
          }
        }
        return 'Get request has been rejected';
    }
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
   * Éditer la priorité des action en raport avec la vidéo.
   *
   * @param       int $value Niveau de priorité pour les action lié a l'importation...
   *                         Niveau de priorité disponibles : <br>
   *                         0: chargement normal ; <br>
   *                         1: normal + vidéos supprimées.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function setPriority($value) {
    $this->priority = (verify::enum($value, [0,1])) ? $value : 0;
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
   * @see         verify
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
   * Récupérer le niveau de priorité de la vidéo.
   *
   * @return      int Le niveau de priorité : 0, 1.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getPriority() {
    return $this->priority;
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
   * <b>Attention:</b> Cette methode initialise aussi l'objet
   * interne Evaluation et Comment de l'objet courrant.
   *
   * @return      boolean True: Importation réussie <br>
   *                      False: Échec importation.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id L'id de la vidéo à importer.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function import(&$errArray, $id) {
    $id = empty($id) ? $this->data['id'] : $id;
    if ($id < 0) {
      addError("L'ID de la vidéo à importer est inconnu", $errArray);
      return false;
    }
    try {
      if ($this->priority == 1) {
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
        $this->evaluationObject = new Evaluation($this->bdd, $this->data['id']);
        $evaluation = $this->evaluationObject->count($errArray);
        if ($evaluation !== false) {
          $this->data['evaluation'] = $evaluation;
        } else {
          addError("Impossible de récupérer la valeur de l'évaluation de la vidéo", $errArray);
        }
        // comment value
        $this->commentObject = new Comment($this->bdd, $this->data['id']);
        $commentVal = $this->commentObject->count($errArray);
        if ($commentVal !== false) {
          $this->data['comment'] = $commentVal;
        } else {
          addError("Impossible de récupérer le nombre de commentaires de la vidéo", $errArray);
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
   * @param       int $limitoffset Tableau contenant la limit puis l'offset de
   *                               la requête select (ex: [5, 10]).
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function exportAll(&$errArray, $id, $limitoffset = null) {
    if (empty($id) || $id <= -1) {
      addError("ID de la chaine invalide invalide", $errArray);
      return false;
    }
    try {
      $addToRequeste = empty($limitoffset) ? '' : secure::sql("LIMIT ".$limitoffset[0].", ".$limitoffset[1]);
      if ($this->priority == 1) {
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
          $video->setPriority($this->priority);
          $video->import($errArray, $value['id_video']);
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
   * Donne accès a l'objet evaluation courant de la vidéo.
   * <b>Nécessite d'avoir précédement importé une vidéo ! ({@see import()})</b>
   *
   * @return      object Objet Evaluation pré initialisé de la vidéo courante.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function evaluation() {
    return $this->evaluationObject;
  }

  /**
   * Donne accès a l'objet comment courant de la vidéo.
   * <b>Nécessite d'avoir précédement importé une vidéo ! ({@see import()})</b>
   *
   * @return      object Objet Comment pré initialisé de la vidéo courante.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function comment() {
    return $this->commentObject;
  }

  /**
   * Effectue une recherche par mot clé dans le site web
   *
   * @return      int|array list de vidéo ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       string $queryRequest query de recherche.
   * @param       array $idMembres Tableau d'id des membres.
   *
   * @since 1.2
   *
   * @author      Jérémi N 'EndMove'
   */
  public function search(&$errArray, $queryRequest, $idMembres) {
    try {
      $fromMembers = "";
      for ($i=0; $i < sizeof($idMembres); $i++) {
        if ($i == sizeof($idMembres)-1) {
          $fromMembers .= $idMembres[$i];
        } else {
          $fromMembers .= $idMembres[$i].',';
        }
      }

      $query = $this->bdd->prepare("SELECT v.id_video
                                    FROM video v
                                    JOIN chaine c ON (c.id_chaine=v.fk_chaine)
                                    WHERE c.fk_compte IN(:idmembres) AND v.intitule like :query");
      $query->bindValue(':idmembres', $fromMembers, PDO::PARAM_STR);
      $query->bindValue(':query', '%'.$queryRequest.'%', PDO::PARAM_STR);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          //addError("Aucun résultat disponible pour votre recherche", $errArray);
          return false;
        }
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $videos = array();
        foreach ($data as $value) {
          $video = new Video($this->bdd);
          $video->setPriority($this->priority);
          $video->import($errArray, $value['id_video']);
          $videos[] = $video;
        }
        return $videos;
      }

    } catch (Exception $e) {
      addError($e, $errArray, true);
    }
    return false;
  }
}