<?php


namespace member;
use dataUtils\verify;
use Exception;
use PDO;
use function Sodium\add;

class Member {
  private $bdd;
  private $id;
  private $lastName;
  private $firstName;
  private $login;
  private $email;
  private $password;
  private $isBlocked;

  const CANT_SET = array('bdd', 'password');
  const CANT_GET = array('bdd', 'id');

  public function __construct($bdd) {
    $this->bdd = !empty($bdd) ? $bdd : NULL;
  }

  public function __get($name) {
    if (!in_array($name, self::CANT_GET)) {
      return $this->$name;
    }
  }

  public function __set($name, $value) {
    if (!in_array($name, self::CANT_SET)) {
      $this->$name = $value;
    }
  }

  public function setData($dataArray) {
    foreach ($dataArray as $name => $value) {
      if (!in_array($name, self::CANT_SET)) {
        $this->$name = $value;
      }
    }
  }

  // private function check(&$errArray) {
  //   $status = true;
  //   if (empty($this->id)) {
  //     addError("L'ID du membre est inconnu", $errArray);
  //     $status = false;
  //   }
  //   if (empty($this->lastName)) {
  //     addError("Le nom du membre est vide", $errArray);
  //     $status = false;
  //   }
  //   if (empty($this->firstName)) {
  //     addError("Le prénom du membre est vide", $errArray);
  //     $status = false;
  //   }
  //   if (empty($this->login)) {
  //     addError("Le prénom du membre est vide", $errArray);
  //     $status = false;
  //   }
  //   if (!verify::email($this->email)) {
  //     addError("L'adresse email est invalide", $errArray);
  //     $status = false;
  //   }
  //   if (!verify::bool($this->isBlocked)) {
  //     addError("Le statut du compte doit être un boolean valide", $errArray);
  //     $status = false;
  //   }
  //   if (!verify::password($this->password)) {
  //     addError("Le mot de passe n'est pas assez fort", $errArray);
  //     $status = false;
  //   }
  //   return $status;
  // }

  // public function exist($email, &$errArray) {
  //   try {
  //     $query = $this->bdd->prepare("SELECT id_compte FROM compte WHERE couriel = :email");
  //     $query->bindValue(':email', $this->email, PDO::PARAM_STR);
  //     if ($query->execute()) {
  //       $count = $query->rowCount();
  //       $query->closeCursor();
  //       if ($count < 0) {
  //         if ($count == 1) {
  //           return true;
  //         } else {
  //           addError("Duplication de compte", $errArray);
  //         }
  //       }
  //     }
  //     $query->closeCursor();
  //   } catch (Exception $e) {
  //     addError($e, $errArray);
  //   }
  //   return false;
  // }

  // public function create($lastName, $firstName, $login, $email, $password, $repeat_password, &$errArray) {

  //   try {
  //     $query = $this->bdd->prepare("INSERT INTO compte
  //                                   (id_compte, nom, prenom, login, couriel, mot_de_passe, est_bloque)
  //                                   VALUES
  //                                   (NULL, :nom, :prenom, :login, :couriel, :mot_de_passe, :est_bloque)");
  //     $query->bindValue(':nom', $this->lastName, PDO::PARAM_STR);
  //     $query->bindValue(':prenom', $this->firstName, PDO::PARAM_STR);
  //     $query->bindValue(':login', $this->login, PDO::PARAM_STR);
  //     $query->bindValue(':couriel', $this->email, PDO::PARAM_STR);
  //     $query->bindValue(':mot_de_passe', $this->password, PDO::PARAM_STR);
  //     $query->bindValue(':est_bloque', $this->isBlocked, PDO::PARAM_BOOL);
  //     if ($query->execute()) {
  //       $query->closeCursor();
  //       return true;
  //     } else {
  //       addError("Erreur lors de l'exécution de la requète SQL", $errArray);
  //     }
  //   } catch (Exception $e) {
  //     addError($e, $errArray);
  //   }
  //   return false;
  // }

  // public function update(&$errArray) {
  //   if (!$this->verify($errArray)) return false;
  //   try {

  //   } catch (Exception $e) {

  //   }
  // }

  // public function import($var, &$errArray) {
  //   try {

  //   } catch (Exception $e) {

  //   }
  // }
}