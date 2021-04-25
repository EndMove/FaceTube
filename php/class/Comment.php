<?php
/**
 * Comment, contien la class de gestion des commentaires des vidéos
 *
 * @package     comment
 *
 * @version     1.0
 *
 * @author      Jérémi Nihart <contact@endmove.eu>
 * @copyright   © 2021 EndMove, Tous droits réservés.
 *
 * @since       1.1.0
 */

namespace video;
use Exception;
use PDO;

/**
 * Comment
 *
 * Cette class permet d'intéragire avec la base de données
 * pour gérer les commentaire de celle-ci (création, suppression, count).
 *
 * @package     video
 *
 * @version     1.0
 * @see         addError()
 * @author      Jérémi N 'EndMove'
 */
class Comment {
  private $bdd;

  public function __construct($bdd) {
    $this->bdd = !empty($bdd) ? $bdd : NULL;
  }

  /**
   * Récupérer une liste de tout les commentaires d'une vidéo.
   *
   * @return      array|boolean Tableau contenant tout les commentaire ou false en cas d'échec.
   * @param       array tableau d'erreurs du site web.
   * @param       int $idVideo ID de la vidéo a laquel on veut ajouter un commentaire.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getAll($errArray, $idVideo) {
    try {
      $query = $this->bdd->prepare("SELECT * FROM commentaire
                                    WHERE fk_video = :fk_video");
      $query->bindValue(':fk_video', $idVideo, PDO::PARAM_INT);
      if ($query->execute()) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
   * Récupérer le nombre de commentaires totale pour une video.
   *
   * @return      array|boolean Tableau contenant tout les commentaire ou false en cas d'échec.
   * @param       array tableau d'erreurs du site web.
   * @param       int $idVideo ID de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function count($errArray, $idVideo) {
    try {
      $query = $this->bdd->prepare("SELECT COUNT(*) AS count FROM commentaire
                                    WHERE fk_video = :fk_video");
      $query->bindValue(':fk_video', $idVideo, PDO::PARAM_INT);
      if ($query->execute()) {
        return $query->fetch(PDO::FETCH_ASSOC)['count'];
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