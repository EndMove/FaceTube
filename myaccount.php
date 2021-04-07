<?php
include("php/includes/pages/myaccount.inc.php");

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

if (isset($_POST['submit'])) {
  $lastname = secure::string($_POST['lastname']);
  $firstname = secure::string($_POST['firstname']);
  $pseudonym = secure::string($_POST['pseudonym']);
  $password = secure::string($_POST['password']);
  $repeat_password = secure::string($_POST['repeat_password']);
  $status = true;

  $data = array(
    'lastname' => $lastname,
    'firstname' => $firstname,
    'login' => $pseudonym
  );

  if (!empty($password)) {
    if (verify::password($password, $infoErrors) && verify::passwordMatch($password, $repeat_password, $infoErrors)) {
      $data['password'] = $password;
    } else {
      $status = false;
    }
  }

  if ($status) {
    $member = new member\Member($bdd);
    if ($member->import($_SESSION['account']['id'], $infoErrors)) {
      $member->setData($data);
      if ($member->update($infoErrors)) {
        $_SESSION['account'] = $member->getData();
        $infoSucc = "Les informations de votre compte on été mises à jour";
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Mon compte</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Votre compte</h1>
    <?php showError($infoErrors); showSuccess($infoSucc); ?>
    <form id="form" class="myaccount" method="POST" action="">
      <div class="field">
        <label for="lastname">Nom</label><input type="text" id="lastname" name="lastname" placeholder="Nihart" value="<?php echo isset($lastname) ? $lastname : $_SESSION['account']['lastname']; ?>">
      </div>
      <div class="field">
        <label for="firstname">Prénom</label><input type="text" id="firstname" name="firstname" placeholder="Jérémi" value="<?php echo isset($firstname) ? $firstname : $_SESSION['account']['firstname']; ?>">
      </div>
      <div class="field">
        <label for="pseudonym">Pseudonyme</label><input type="text" id="pseudonym" name="pseudonym" placeholder="EndMove" value="<?php echo isset($pseudonym) ? $pseudonym : $_SESSION['account']['login']; ?>">
      </div>
      <div class="field">
        <label for="email">Email</label><input type="email" id="email" name="email" placeholder="contact@endmove.eu" value="<?php echo $_SESSION['account']['email']; ?>" disabled>
      </div>
      <div class="field">
        <label for="password">Nouveau mot de passe</label><input type="password" id="password" name="password" placeholder="***********">
      </div>
      <div class="field">
        <label for="repeat_password">Répéter nouveau mot de passe</label><input type="password" id="repeat_password" name="repeat_password" placeholder="***********">
      </div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Sauvegarder">
        </div>
      </div>
    </form>

    <div class="myaccount">
      <a class="btn-link blue" href="profile.php"><span>Votre Profil</span></a>
      <a class="btn-link blue" href="friends.php"><span>Vos Amis</span></a>
    </div>

  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>