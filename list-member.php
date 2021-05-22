<?php
include("php/includes/pages/list-member.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Liste des membres</title>
  <!-- End Header -->
</head>
<body>
<header>
  <!-- Nav -->
  <?php include("php/includes/nav.inc.php"); ?>
  <!-- End Nav -->
</header>

<main>
  <h1 class="text-center">Liste des membres</h1>
  <?php showError($infoErrors); showSuccess($infoSucc); ?>

  <section class="friends">

    <div class="flex add">
      <h2>&nbsp;</h2>
      <form id="search-bar" class="align-right" method="POST" action="<?php echo $formAction; ?>">
        <input type="text" id="query" name="search" placeholder="Rechercher un membre...">
        <button><i class="fas fa-search"></i></button>
      </form>
    </div>

    <?php
    if (is_array($items)) {
      foreach ($items as $item) {
        ?>
        <article class="user-item">
          <img src="images/user.png" alt="Photo de profil">
          <div class="flex col content">
            <span class="title"><?php echo strtoupper($item['login']) . ' - ' . $item['prenom'] . ' ' . $item['nom']; ?></span>
            <span class="date"><?php echo $item['couriel']; ?></span>
          </div>
          <div class="flex align-right btn">
            <a class="btn-link blue" href="<?php echo 'profile.php?id='.$item['id_compte']; ?>"><span><i class="fas fa-eye"></i></span></a>
            <form method="POST" action="<?php echo $formAction; ?>">
              <input type="number" name="user_id" value="<?php echo $item['id_compte']; ?>" hidden>
              <input class="<?php echo $item['est_bloque'] ? 'green' : 'red'; ?>" type="submit" name="blocked" value="<?php echo $item['est_bloque'] ? 'Débloquer' : 'Bloquer'; ?>">
            </form>
          </div>
        </article>
        <?php
      }
    } else {
      showInfo("Aucun résultat de recherche");
    }
    ?>

  </section>
</main>

<!-- Footer -->
<?php include("php/includes/footer.inc.php"); ?>
<!-- End Footer -->
</body>
</html>