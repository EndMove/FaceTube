<?php
/**
 * Evaluation, contien la class de gestion des évaluation des vidéos
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
use Verify;

/**
 * Evaluation
 *
 * Cette class permet d'intéragire avec la base de données
 * pour gérer les évaluation d'un video (création, suppression, count).
 *
 * @package     video
 *
 * @version     1.0
 * @see         addError()
 * @author      Jérémi N 'EndMove'
 */
class Evaluation {
  private $bdd;
  private $idVideo;

  public function __construct($bdd, $idVideo) {
    $this->bdd = empty($bdd) ? NULL : $bdd;
    $this->idVideo = empty($idVideo) || !is_numeric($idVideo) ? -1 : $idVideo;
  }

  /**
   * Récupérer l'évaluation d'un membre.
   *
   * @return      int|boolean Évaluatio d'un membre ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       int $idMember L'id du membre.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getEvaluationOfAMember(&$errArray, $idMember) {
    try {
      $query = $this->bdd->prepare("SELECT evaluation
                                    FROM evaluer
                                    WHERE id_compte = :id_compte AND id_video = :id_video");
      $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
      $query->bindValue(':id_video', $this->idVideo, PDO::PARAM_INT);
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
   * @return      boolean true (succès) ou false en cas d'échec.
   * @param       array $errArray Le tableau d'erreurs du siteweb.
   * @param       int $idMember L'id du membre qui veut évaluer la vidéo.
   * @param       int $choice Cote de l'évaluation.
   * @param       int $idVideo L'id de la vidéo.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function addEvaluation(&$errArray, $idMember, $choice) {
    if (!verify::enum($choice, ['-1','1','2','3','4','5'])) {
      addError("Valeur entré dans le système d'évaluation incorrect [-1,1,2,3,4,5]", $errArray);
      return false;
    }
    try {
      $getEval = $this->getEvaluationOfAMember($errArray, $idMember);
      if ($getEval) {
        if ($choice == '-1') {
          $query = $this->bdd->prepare("DELETE FROM evaluer
                                        WHERE id_compte = :id_compte AND id_video = :id_video");
          $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
          $query->bindValue(':id_video', $this->idVideo, PDO::PARAM_INT);
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
          $query->bindValue(':id_video', $this->idVideo, PDO::PARAM_INT);
          $query->bindValue(':evaluation', $choice, PDO::PARAM_INT);
          if ($query->execute()) {
            $query->closeCursor();
            return true;
          } else {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          }
        }
      } elseif ($choice != '-1') {
        $query = $this->bdd->prepare("INSERT INTO evaluer
                                      (id_compte, id_video, evaluation)
                                      VALUES
                                      (:id_compte, :id_video, :evaluation)");
        $query->bindValue(':id_compte', $idMember, PDO::PARAM_INT);
        $query->bindValue(':id_video', $this->idVideo, PDO::PARAM_INT);
        $query->bindValue(':evaluation', $choice, PDO::PARAM_INT);
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
   * Génère une cote sur 5 avec les évaluations.
   *
   * @return      boolean|int Cote de 0 à 5 ou false si erreur.
   * @param       array $errArray Tableau d'erreurs du siteweb.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function countEvaluation(&$errArray) {
    try {
      $query = $this->bdd->prepare("SELECT AVG(evaluation) AS score
                                    FROM evaluer
                                    WHERE id_video = :id_video");
      $query->bindValue(':id_video', $this->idVideo, PDO::PARAM_INT);
      if ($query->execute()) {
        $count = $query->rowCount();
        if ($count > 0) {
          return round($query->fetch(PDO::FETCH_ASSOC)['score']);

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