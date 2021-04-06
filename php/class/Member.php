<?php
/**
 * Member, permet la gestion d'un utilisateur
 * création, import, update...
 *
 * @package     member
 *
 * @version     1.0
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
 * @version     1.0
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
      'isblocked' => false
    );
  }

  /**
   * Récupérer une donnée de l'utilisateur.
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
   * Éditer une donnée de l'utilisateur en local.
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
   * Récupérer des données local de l'utilisateur
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
   * Éditer des données de l'utilisateur en local.
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
   * Description de la méthode.
   * Explication supplémentaire si nécessaire...
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
   * Vérifie si une donnée avec l'email ou le login de cet objet existe déjà.
   *
   * @return      boolean True: donné existe <br>
   *                      False: donnée n'existe pas.
   * @param       string $type <b>'email'</b> check with email <br>
   *                           <b>'login'</b> check with login
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function exist($type = 'email', &$errArray = null) {
    try {
      switch ($type) {
        case 'email':
          $query = $this->bdd->prepare("SELECT id_compte FROM compte WHERE couriel = :email AND id_compte != :id");
          $query->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
          $query->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
          break;
        default:
          $query = $this->bdd->prepare("SELECT id_compte FROM compte WHERE login = :login AND id_compte != :id");
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
   * Permet d'authentifier un utilisateur renvoie un id si succès.
   *
   * @return      integer|boolean L'id du compte membre ou false en cas d'erreur.
   * @param       string $email Adresse email du compte.
   * @param       string $password Le mot de passe du compte.
   * @param       array $errArray Tableau d'erreurs du projet.
   *
   * @since 1.0
   *
   * @author      Jérémi N 'EndMove'
   */
  public function auth($email, $password, &$errArray) {
    try {
      $query = $this->bdd->prepare("SELECT id_compte, est_bloque FROM compte WHERE couriel = :couriel AND mot_de_passe = :mot_de_passe");
      $query->bindValue(':couriel', $email, PDO::PARAM_STR);
      $query->bindValue(':mot_de_passe', hashPassword($password), PDO::PARAM_STR);
      if ($query->execute()) {
        if ($query->rowCount() <= 0) {
          addError("Mot de passe et ou adresse email incorrect", $errArray);
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
    if ($this->exist('email', $errArray)) {
      addError("Un compte avec cette adresse email exist déjà", $errArray);
      return false;
    } else if ($this->exist('login', $errArray)) {
      addError("Un compte avec ce login exist déjà", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("INSERT INTO compte
                                      (id_compte, nom, prenom, login, couriel, mot_de_passe, est_bloque)
                                    VALUES
                                      (NULL, :nom, :prenom, :login, :couriel, :mot_de_passe, :est_bloque)");
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
   * Permet de mettre à jour un membre avec les données cocale de l'objet.
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
    if ($this->exist('email', $errArray)) {
      addError("Un compte avec cette adresse email exist déjà", $errArray);
      return false;
    } else if ($this->exist('login', $errArray)) {
      addError("Un compte avec ce login exist déjà", $errArray);
      return false;
    }
    try {
      $query = $this->bdd->prepare("UPDATE compte
                                    SET
                                      nom = :nom, prenom = :prenom, login = :login, couriel = :couriel, mot_de_passe = :mot_de_passe, est_bloque = :est_bloque
                                    WHERE 
                                      id_compte = :id");
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

  public function import($id, &$errArray) {
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