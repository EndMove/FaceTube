<?php
$page = "contact"; include("core.php");
/**
 * Powered By EndMove 2020-2021 All Rights Reserved.
 * Version: 1.0 - Date: 24-12-2020
 */

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
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

    <section class="friends">
      <h2>Demandes d'amis reçues</h2>

      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title">K/DA</span>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="green" type="submit" name="accept" value="Accepter">
          </form>
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="refuse" value="Refuser">
          </form>
        </div>
      </article>

      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title">K/DA</span>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="green" type="submit" name="accept" value="Accepter">
          </form>
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="refuse" value="Refuser">
          </form>
        </div>
      </article>

    </section>

    <section class="friends">
      <div class="flex add">
        <h2>Demandes d'amis en attentes</h2>
        <form id="search-bar" class="align-right" method="POST">
          <input type="text" id="query" name="add_friend" placeholder="Ajouter un ami...">
          <button><i class="fas fa-plus"></i></button>
        </form>
      </div>
      
      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title">K/DA</span>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="cancel" value="Annuler">
          </form>
        </div>
      </article>

      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <span class="title">K/DA</span>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="cancel" value="Annuler">
          </form>
        </div>
      </article>

    </section>

    <section class="friends">
      <h2>Amis</h2>

      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <a href="profile.php"><span class="title">K/DA</span></a>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <a class="btn-link blue" href="profile.php"><span><i class="fas fa-eye"></i></span></a>
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="remove" value="Remove">
          </form>
        </div>
      </article>

      <article class="user-item">
        <img src="upload/user2.jpg" alt="Photo de profil">
        <div class="flex col content">
          <a href="profile.php"><span class="title">K/DA</span></a>
          <span class="date">Le 13 novembre 2020</span>
        </div>
        <div class="flex align-right btn">
          <a class="btn-link blue" href="profile.php"><span><i class="fas fa-eye"></i></span></a>
          <form method="POST">
            <input type="number" name="user_id" hidden>
            <input class="red" type="submit" name="remove" value="Remove">
          </form>
        </div>
      </article>

    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>