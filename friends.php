<?php
include("php/includes/pages/friends.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Liste d'amis</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Liste d'Amis</h1>
    <?php showError($infoErrors); showSuccess($infoSucc); ?>
    <section class="friends">
      <h2>Demandes d'amis reçues</h2>

      <?php
      if (is_array($friendReceived)) {
        foreach ($friendReceived as $item) {
      ?>
      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title"><?php echo strtoupper($item['login']) . ' - ' . $item['firstname'] . ' ' . $item['lastname']; ?></span>
          <span class="date">Le D M Y</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST" action="">
            <input type="number" name="user_id" value="<?php echo $item['id']; ?>" hidden>
            <input class="green" type="submit" name="accept" value="Accepter">
          </form>
          <form method="POST" action="">
            <input type="number" name="user_id" value="<?php echo $item['id']; ?>" hidden>
            <input class="red" type="submit" name="reject" value="Refuser">
          </form>
        </div>
      </article>
      <?php
        }
      } else {
        showInfo("Aucune demande d'amis en attente de confirmation pour le moment");
      }
      ?>

    </section>

    <section class="friends">

      <div class="flex add">
        <h2>Demandes d'amis en attentes</h2>
        <form id="search-bar" class="align-right" method="POST" action="">
          <input type="text" id="query" name="add_friend" placeholder="Ajouter un ami...">
          <button><i class="fas fa-plus"></i></button>
        </form>
      </div>

      <?php
      if (is_array($friendSent)) {
        foreach ($friendSent as $item) {
      ?>
      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title"><?php echo strtoupper($item['login']) . ' - ' . $item['firstname'] . ' ' . $item['lastname']; ?></span>
          <span class="date">Le D M Y</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="number" name="user_id" value="<?php echo $item['id']; ?>" hidden>
            <input class="red" type="submit" name="cancel" value="Annuler">
          </form>
        </div>
      </article>
      <?php
        }
      } else {
        showInfo("Aucune demande d'amis en attente d'acceptation pour le moment");
      }
      ?>

    </section>

    <section class="friends">
      <h2>Amis</h2>

      <?php
      if (is_array($friendList)) {
        foreach ($friendList as $item) {
      ?>
      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <a href="<?php echo 'profile.php?id='.$item['id']; ?>"><span class="title"><?php echo strtoupper($item['login']) . ' - ' . $item['firstname'] . ' ' . $item['lastname']; ?></span></a>
          <span class="date">Le D M Y</span>
        </div>
        <div class="flex align-right btn">
          <a class="btn-link blue" href="<?php echo 'profile.php?id='.$item['id']; ?>"><span><i class="fas fa-eye"></i></span></a>
          <form method="POST" action="">
            <input type="number" name="user_id" value="<?php echo $item['id']; ?>" hidden>
            <input class="red" type="submit" name="remove" value="Remove">
          </form>
        </div>
      </article>
          <?php
        }
      } else {
        showInfo("Aucune ami pour le moment, :O But where are them ?!");
      }
      ?>

    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>