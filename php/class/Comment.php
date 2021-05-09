<?php
/**
 * Comment, contien la class de gestion des commentaires des vidéos
 *
 * @package     video
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
  private $idVideo;

  public function __construct($bdd, $idVideo) {
    $this->bdd = empty($bdd) ? NULL : $bdd;
    $this->idVideo = empty($idVideo) || !is_numeric($idVideo) ? -1 : $idVideo;
  }

  /**d
   * Récupérer une liste de tout les commentaires d'une vidéo du plus vieux
   * au plus récent.
   *
   * @return      array|boolean Tableau contenant tout les commentaire ou false en cas d'échec.
   * @param       array tableau d'erreurs du site web.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getAll(&$errArray) {
    try {
      $query = $this->bdd->prepare("SELECT * FROM commentaire
                                    WHERE fk_video = :fk_video
                                    ORDER BY date_publication ASC");
      $query->bindValue(':fk_video', $this->idVideo, PDO::PARAM_INT);
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
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function count(&$errArray) {
    try {
      $query = $this->bdd->prepare("SELECT COUNT(*) AS count FROM commentaire
                                    WHERE fk_video = :fk_video");
      $query->bindValue(':fk_video', $this->idVideo, PDO::PARAM_INT);
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

  /**
   * Ajoute un commentaire à la vidéo.
   *
   * @return      boolean True: ajout réussi,
   *                      False: ajout erreur.
   * @param       array Tableau d'erreurs du site web.
   * @param       int L'ID du membre.
   * @param       string Valeur du commentaire.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function add(&$errArray, $idMember, $value) {
    try {
      if (empty($value)) {
        addError('Le commentaire ne peux pas être vide !', $errArray);
        return false;
      }
      $query = $this->bdd->prepare("INSERT INTO commentaire
                                    (id_commentaire, fk_compte, fk_video, commentaire, date_publication)
                                    VALUES
                                    (NULL, :idCompte, :idVideo, :val, NOW())");
      $query->bindParam(':idCompte', $idMember, PDO::PARAM_INT);
      $query->bindParam('idVideo', $this->idVideo, PDO::PARAM_INT);
      $query->bindParam(':val', $value, PDO::PARAM_STR);
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
   * Supprimer un commentaire de la vidéo.
   *
   * @return      boolean True: suppression réussie,
   *                      False: suppression erreur.
   * @param       array Tableau d'erreurs du site web.
   * @param       int ID du comentaire.
   * @param       int L'ID du membre.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function remove(&$errArray, $idComment, $idMember) {
    try {
      if (!is_numeric($idComment)) {
        addError("L'ID du commentaire doit être un nombre !", $errArray);
        return false;
      }
      $query = $this->bdd->prepare("SELECT id_commentaire
                                    FROM commentaire
                                    WHERE id_commentaire = :idComment AND fk_compte = :idCompte AND fk_video = :idVideo");
      $query->bindValue(':idComment', $idComment, PDO::PARAM_INT);
      $query->bindValue(':idCompte', $idMember, PDO::PARAM_INT);
      $query->bindValue(':idVideo', $this->idVideo, PDO::PARAM_INT);
      if ($query->execute() && ($query->rowCount() == 1)) {
        $query = $this->bdd->prepare("DELETE FROM commentaire
                                    WHERE id_commentaire = :idComment");
        $query->bindValue(':idComment', $idComment, PDO::PARAM_INT);
        if ($query->execute()) {
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
}