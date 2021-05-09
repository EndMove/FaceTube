<?php
/**
 * Member, permet la gestion d'un utilisateur
 * création, import, update...
 *
 * @package     member
 *
 * @version     1.1
 *
 * @author      Jérémi Nihart <contact@endmove.eu>
 * @copyright   © 2021 EndMove, Tous droits réservés.
 *
 * @since       1.0.0
 */

namespace member;
use Exception;
use PDO;
use verify;

/**
 * Member
 *
 * Cette classe permet de gérer un membre du site web
 * <ul>
 *  <li>Création</li>
 *  <li>Édition</li>
 *  <li>Suppression</li>
 *  <li>...</li>
 * </ul>
 *
 * @package     member
 *
 * @version     1.1
 * @see         verify
 * @see         addError()
 * @see         removeAccents()
 * @see         hashPassword()
 * @author      Jérémi N 'EndMove'
 */
class Member {
  private $bdd;
  private $data;

  const CANT_SET = array('bdd', 'id');
  const CANT_GET = array('bdd', 'password');

  public function __construct($bdd) {
    $this->bdd = !empty($bdd) ? $bdd : NULL;
    $this->data = array(
      'id' => -1,
      'lastname' => NULL,
      'firstname' => NULL,
      'login' => NULL,
      'email' => NULL,
      'password' => NULL,
      'isblocked' => false,
      'isadmin' => false
    );
  }

  /**
   * Récupérer une donnée local de l'utilisateur.
   *
   * @return      string Contenu de la donnée utilisateur demandé.
   * @param       string $name Nom de la donnée utilisateur souhaité.
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
   * Éditer une donnée local de l'utilisateur.
   * Voir {@see update()} pour mettre à jour en base de données.
   *
   * @param       string $name Nom de la donnée à modifier.
   * @param       string|boolean $value Nouvelle valeur de la donnée.
   *
   * @since 1.0
   *
   * @see         removeAccents()
   * @see         hashPassword()
   * @author      Jérémi N 'EndMove'
   */
  public function __set($name, $value) {
    if (!in_array($name, self::CANT_SET)) {
      if (array_key_exists($name, $this->data)) {
        switch ($name) {
          case 'email':
          case 'login':
            $this->data[$name] = strtolower(removeAccents($value));
            break;
          case 'password':
            $this->data[$name] = hashPassword($value);
            break;
          default:
            $this->data[$name] = $value;
            break;
        }
      }
    }
  }

  /**
   * Éditer des données locales de l'utilisateur.
   * Voir {@see update()} pour mettre à jour en base de données.
   *
   * @param       array $dataArray Tableau de données :
   *                               array('lastname' => 'Un Nom', ...);
   *
   * @since 1.0
   *
   * @see         removeAccents()
   * @see         hashPassword()
   * @author      Jérémi N 'EndMove'
   */
  public function setData($dataArray) {
    foreach ($dataArray as $name => $value) {
      if (!in_array($name, self::CANT_SET)) {
        switch ($name) {
          case 'email':
          case 'login':
            $this->data[$name] = strtolower(removeAccents($value));
            break;
          case 'password':
            $this->data[$name] = hashPassword($value);
            break;
          default:
            $this->data[$name] = $value;
            break;
        }
      }
    }
  }

  /**
   * Récupérer des données locales de l'utilisateur
   *
   * @return      array Tableau de données du membre.
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
   * Récupère l'id d'un membre en fonction d'un login/email.
   *
   * @return      int L'id de l'utilisateur.
   * @param       array $errArray Tableau d'erreur du siteweb.
   * @param       string $value Un <u>email</u> ou un <u>login</u>.
   *
   * @since 1.1
   *
   * @see         removeAccents()
   * @see         verify::email()
   * @author      Jérémi N 'EndMove'
   */
  public function getID(&$errArray, $value) {
    try {
      $value = strtolower(removeAccents($value));
      if (verify::email($value)) {
        $query = $this->bdd->prepare("SELECT id_compte
                                      FROM compte
                                      WHERE couriel = :couriel");
        $query->bindValue(':couriel', $value, PDO::PARAM_STR);
      } else {
        $query = $this->bdd->prepare("SELECT id_compte
                                      FROM compte
                                      WHERE login = :login");
        $query->bindValue(':login', $value, PDO::PARAM_STR);
      }
      if ($query->execute()) {
        return $query->fetch(PDO::FETCH_ASSOC)['id_compte'];
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
   * Récupère le login d'un membre en fonction de son id.
   *
   * @return      string|boolean Le pseudo du membre ou false en cas d'échec.
   * @param       array $errArray Tableau d'erreur du siteweb.
   * @param       int $idMember L'id d'un membre.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getPseudoByID(&$errArray, $idMember) {
    try {
      $query = $this->bdd->prepare("SELECT login
                                    FROM compte
                                    WHERE id_compte = :id");
      $query->bindValue(':id', $idMember, PDO::PARAM_INT);
      if ($query->execute()) {
        return $query->fetch(PDO::FETCH_ASSOC)['login'];
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
    if (empty($this->data['lastname'])) {
      addError("Le nom du membre est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['firstname'])) {
      addError("Le prénom du membre est vide", $errArray);
      $status = false;
    }
    if (empty($this->data['login'])) {
      addError("Le login du membre est vide", $errArray);
      $status = false;
    }
    if (!verify::email($this->data['email'], $errArray)) {
      $status = false;
    }
    if (!verify::bool($this->data['isblocked'], $errArray)) {
      $status = false;
    }
    return $status;
  }

  /**
   * Permet de vérifier si l'email ou le login <b>lacal</b>
   * est déjà ou non utilisé par un autre membre <b>en base de données</b>.
   *
   * @return      boolean True: donnée déjà utilisé <br>
   *                      False: donnée pas encore utilisé.
   * @param       string $type <b>'email'</b> check with email <br>
   *                           <b>'login'</b> check with login
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  private function used($type = 'email', &$errArray = null) {
    try {
      switch ($type) {
        case 'email':
          $query = $this->bdd->prepare("SELECT id_compte
                                        FROM compte
                                        WHERE couriel = :email AND id_compte != :id");
          $query->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
          $query->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
          break;
        default:
          $query = $this->bdd->prepare("SELECT id_compte
                                        FROM compte
                                        WHERE login = :login AND id_compte != :id");
          $query->bindValue(':login', $this->data['login'], PDO::PARAM_STR);
          $query->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
          break;
      }
      if ($query->execute()) {
        $count = $query->rowCount();
        $query->closeCursor();
        if ($count > 0) {
          return true;
        }
      }
      $query->closeCursor();
    } catch (Exception $e) {
      addError($e, $errArray, true);
    }
    return false;
  }

  /**
   * Vérifie si il exist un utilisateur avec cet id.
   *
   * @return      boolean True: Il exist un compte <br>
   *                      False: Il n'exist aucun compte
   * @param       array $errArray Tableau d'erreurs du projet.
   * @param       int $id L'id du compte de l'utilsiateur.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function exist(&$errArray, $id) {
    try {
      $query = $this->bdd->prepare("SELECT id_compte
                                    FROM compte
                                    WHERE id_compte = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() > 0) return true;
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
   * Permet d'authentifier un utilisateur renvoie un id si succès.
   *
   * @return      integer|boolean L'id du compte membre ou false en cas d'erreur.
   * @param       array $errArray Tableau d'erreurs du projet.
   * @param       string $value Adresse email du compte ou login du compte.
   * @param       string $password Le mot de passe du compte.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function auth(&$errArray, $value, $password) {
    try {
      $value = strtolower(removeAccents($value));
      if (verify::email($value)) {
        $query = $this->bdd->prepare("SELECT id_compte, est_bloque
                                      FROM compte
                                      WHERE couriel = :couriel AND mot_de_passe = :mot_de_passe");
        $query->bindValue(':couriel', $value, PDO::PARAM_STR);
      } else {
        $query = $this->bdd->prepare("SELECT id_compte, est_bloque
                                      FROM compte
                                      WHERE login = :login AND mot_de_passe = :mot_de_passe");
        $query->bindValue(':login', $value, PDO::PARAM_STR);
      }
      $query->bindValue(':mot_de_passe', hashPassword($password), PDO::PARAM_STR);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Identifiants incorrects ou compte inexistant", $errArray);
          return false;
        }
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if ($data['est_bloque']) {
          addError("Ce compte a été bloqué par un administrateur", $errArray);
        } else {
          return $data['id_compte'];
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
   * Permet de créer un nouvelle utilisateur en fonction
   * des valeurs définie via {@see setData()} ou manuellement
   * <code>$membre->firstname = 'Un prénom'</code>
   *
   * @return      boolean True: inscription réussie <br>
   *                      False: échec inscription.
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

  /**
   * Permet de mettre à jour un membre avec les données cocales de l'objet.
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
      addError("L'ID du compte à mettre à jour est inconnue", $errArray);
      return false;
    }
    if ($this->used('email', $errArray)) {
      addError("Un compte avec cette adresse email exist déjà", $errArray);
      return false;
    } else if ($this->used('login', $errArray)) {
      addError("Un compte avec ce login exist déjà", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("UPDATE compte
                                    SET nom = :nom, prenom = :prenom, login = :login, couriel = :couriel, mot_de_passe = :mot_de_passe, est_bloque = :est_bloque
                                    WHERE id_compte = :id");
      $query->bindValue(':nom', $this->data['lastname'], PDO::PARAM_STR);
      $query->bindValue(':prenom', $this->data['firstname'], PDO::PARAM_STR);
      $query->bindValue(':login', $this->data['login'], PDO::PARAM_STR);
      $query->bindValue(':couriel', $this->data['email'], PDO::PARAM_STR);
      $query->bindValue(':mot_de_passe', $this->data['password'], PDO::PARAM_STR);
      $query->bindValue(':est_bloque', $this->data['isblocked'], PDO::PARAM_BOOL);
      $query->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
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
   * @param       int $id L'id du membre.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function import(&$errArray, $id) {
    $id = empty($id) ? $this->data['id'] : $id;
    try {
      $query = $this->bdd->prepare("SELECT * FROM compte WHERE id_compte = :id");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Il n'existe aucun membre aillant l'id: $id", $errArray);
          return false;
        }
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $this->data['id'] = $data['id_compte'];
        $this->data['lastname'] = $data['nom'];
        $this->data['firstname'] = $data['prenom'];
        $this->data['login'] = $data['login'];
        $this->data['email'] = $data['couriel'];
        $this->data['password'] = $data['mot_de_passe'];
        $this->data['isblocked'] = $data['est_bloque'];
        $this->data['isadmin'] = $data['est_admin'];
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
   * Récupérer les demandes d'ami sous forme d'un tableau numéroté.
   *
   * @return      array|string Tableau des demandes d'ami ou none si aucune.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id ID du membre auquel récupérer les demandes.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getFriendRequestsReceived(&$errArray, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    try {
      $query = $this->bdd->prepare("SELECT c.id_compte AS id, c.nom AS lastname, c.prenom AS firstname, c.login
                                    FROM demande d JOIN compte c ON (d.id_compte_demandeur=c.id_compte)
                                    WHERE d.id_compte_destinataire = :id AND d.est_acceptee = false");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          return 'none';
        }
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
   * Récupérer les demandes d'ami envoyées sous forme d'un tableau numéroté.
   *
   * @return      array|false Tableau des demandes d'ami envoyées.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id ID du membre auquel récupérer les demandes.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getFriendRequestsSent(&$errArray, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    try {
      $query = $this->bdd->prepare("SELECT c.id_compte AS id, c.nom AS lastname, c.prenom AS firstname, c.login
                                    FROM demande d JOIN compte c ON (d.id_compte_destinataire=c.id_compte)
                                    WHERE d.id_compte_demandeur = :id AND d.est_acceptee = false");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          return 'none';
        }
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
   * Récupérer la liste d'ami sous forme d'un tableau numéroté.
   *
   * @return      array|false Tableau d'amis.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id ID du membre auquel récupérer les amis.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function getFriendList(&$errArray, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    try {
      $query = $this->bdd->prepare("SELECT c.id_compte AS id, c.nom AS lastname, c.prenom AS firstname, c.login
                                    FROM demande d JOIN compte c ON (d.id_compte_demandeur=c.id_compte)
                                    WHERE d.id_compte_destinataire = :id AND d.est_acceptee = true
                                    UNION
                                    SELECT c.id_compte AS id, c.nom AS lastname, c.prenom AS firstname, c.login
                                    FROM demande d JOIN compte c ON (d.id_compte_destinataire=c.id_compte)
                                    WHERE d.id_compte_demandeur = :id AND d.est_acceptee = true");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          return 'none';
        }
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
   * Effectuer une action sur la relation d'amitié
   * (ajouter, accepter, refuser, supprimer, annuler).
   *
   * @return      boolean True: succès <br>
   *                      False: erreur.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $id ID du membre effectuant l'action.
   * @param       int $idFriend ID du membre sur lequel effectuer l'action.
   * @param       string $status L'action. Les disponibles sont:<br>
   *                             <ul>
   *                              <li>'add' => envoyer une demande d'ami ;</li>
   *                              <li>'accept' => accepter une demande d'ami ;</li>
   *                              <li>'reject' => refuser une demande d'ami ;</li>
   *                              <li>'cancel' => annuler une demande envoyer, en attente ;</li>
   *                              <li>'remove' => supprimer un ami.</li>
   *                             </ul>
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function updateFriend(&$errArray, $id, $idFriend, $status) {
    if ($id == $idFriend) {
      addError("Vous ne pouvez pas vous inviter vous même et ou vous supprimer des amis", $errArray);
      return false;
    }
    try {
      switch ($status) {
        case 'add':
          $query = $this->bdd->prepare("SELECT 'ok' AS status
                                        FROM demande
                                        WHERE id_compte_destinataire = :id AND id_compte_demandeur = :id_friend
                                        UNION
                                        SELECT 'ok' AS status
                                        FROM demande
                                        WHERE id_compte_demandeur = :id AND id_compte_destinataire = :id_friend");
          $query->bindValue(':id', $id, PDO::PARAM_INT);
          $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
          if (!$query->execute()) {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          } else {
            if ($query->rowCount() > 0) {
              $query->closeCursor();
              addError("Vous avez déjà demandé ou reçu une demande d'ami de cette personne", $errArray);
            } else {
              $query = $this->bdd->prepare("INSERT INTO demande SET id_compte_demandeur = :id, id_compte_destinataire = :id_friend");
              $query->bindValue(':id', $id, PDO::PARAM_INT);
              $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
              if (!$query->execute()) {
                $query->closeCursor();
                addError("Erreur lors de l'exécution de la requète SQL", $errArray);
              } else {
                $query->closeCursor();
                return true;
              }
            }
          }
          break;
        case 'accept':
          $query = $this->bdd->prepare("SELECT 'ok' AS status
                                        FROM demande
                                        WHERE id_compte_destinataire = :id AND id_compte_demandeur = :id_friend AND est_acceptee = false");
          $query->bindValue(':id', $id, PDO::PARAM_INT);
          $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
          if (!$query->execute()) {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          } else {
            if ($query->rowCount() <= 0) {
              $query->closeCursor();
              addError("Vous n'avez aucune demande en cours avec cette personne", $errArray);
            } else {
              $query = $this->bdd->prepare("UPDATE demande
                                            SET est_acceptee = true
                                            WHERE (id_compte_destinataire = :id AND id_compte_demandeur = :id_friend)
                                            OR (id_compte_demandeur = :id AND id_compte_destinataire = :id_friend)");
              $query->bindValue(':id', $id, PDO::PARAM_INT);
              $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
              if (!$query->execute()) {
                $query->closeCursor();
                addError("Erreur lors de l'exécution de la requète SQL", $errArray);
              } else {
                $query->closeCursor();
                return true;
              }
            }
          }
          break;
        case 'reject':
        case 'cancel':
        case 'remove':
          $query = $this->bdd->prepare("SELECT 'ok' AS status
                                        FROM demande
                                        WHERE id_compte_destinataire = :id AND id_compte_demandeur = :id_friend
                                        UNION
                                        SELECT 'ok' AS status
                                        FROM demande
                                        WHERE id_compte_demandeur = :id AND id_compte_destinataire = :id_friend");
          $query->bindValue(':id', $id, PDO::PARAM_INT);
          $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
          if (!$query->execute()) {
            $query->closeCursor();
            addError("Erreur lors de l'exécution de la requète SQL", $errArray);
          } else {
            if ($query->rowCount() <= 0) {
              $query->closeCursor();
              addError("Vous n'avez aucun contact avec cette personne", $errArray);
            } else {
              $query = $this->bdd->prepare("DELETE FROM demande
                                            WHERE (id_compte_destinataire = :id AND id_compte_demandeur = :id_friend)
                                            OR (id_compte_demandeur = :id AND id_compte_destinataire = :id_friend)");
              $query->bindValue(':id', $id, PDO::PARAM_INT);
              $query->bindValue(':id_friend', $idFriend, PDO::PARAM_INT);
              if (!$query->execute()) {
                $query->closeCursor();
                addError("Erreur lors de l'exécution de la requète SQL", $errArray);
              } else {
                $query->closeCursor();
                return true;
              }
            }
          }
          break;
      }
    } catch (Exception $e) {
      addError($e, $errArray, true);
    }
    return false;
  }

  /**
   * Vérifier si deux comptes ce sont en amis ou pas.
   *
   * @return      boolean True: sont amis <br>
   *                      False: ne sont pas amis.
   * @param       array $errArray Tableau d'erreurs.
   * @param       int $idFriend ID du compte de "l'ami".
   * @param       int $id ID du compte courant.
   *
   * @since 1.1
   *
   * @author      Jérémi N 'EndMove'
   */
  public function isFriend(&$errArray, $idFriend, $id = null) {
    $id = empty($id) ? $this->data['id'] : $id;
    try {
      $query = $this->bdd->prepare("SELECT est_acceptee
                                    FROM demande
                                    WHERE ((id_compte_destinataire = :id AND id_compte_demandeur = :id_friend)
                                    OR (id_compte_demandeur = :id AND id_compte_destinataire = :id_friend))
                                    AND est_acceptee = true");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      $query->bindValue('id_friend', $idFriend, PDO::PARAM_INT);
      if ($query->execute()) {
        if ($query->rowCount() > 0) {
          return true;
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