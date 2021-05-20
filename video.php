<?php
include("php/includes/pages/video.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Vidéo</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <form id="search-bar" method="POST" action="search.php">
      <input type="text" id="query" name="query" placeholder="Rechercher par mot clé...">
      <button><i class="fas fa-search"></i></button>
    </form>

    <section id="video">
      <section class="content text-center">
        <?php echo htmlspecialchars_decode($video->fragment); ?>
      </section>

      <section class="meta">
        <h1><?php echo $video->title; ?></h1>
        <div class="flex wrap">
          <div class="stats">
            <span><i class="far fa-eye"></i> <?php echo $video->views ?></span>
            <span><i class="far fa-clock"></i> <?php echo $video->duration; ?></span>
            <span><i class="far fa-comments"></i> <?php echo $video->comment; ?></span>
          </div>
          <div class="flex options">
            <span class="noflex"> <?php echo $video->evaluation.'/5'; ?> <i class="far fa-star"></i></span>
            <form class="flex" method="POST" action="<?php echo $formAction; ?>">
              <select name="score">
                <option value="-1" <?php echo ($eval == false) ? 'selected' : ''?>>X</option>
                <option value="1" <?php echo ($eval == '1') ? 'selected' : ''?>>1</option>
                <option value="2" <?php echo ($eval == '2') ? 'selected' : ''?>>2</option>
                <option value="3" <?php echo ($eval == '3') ? 'selected' : ''?>>3</option>
                <option value="4" <?php echo ($eval == '4') ? 'selected' : ''?>>4</option>
                <option value="5" <?php echo ($eval == '5') ? 'selected' : ''?>>5</option>
              </select>
              <input type="submit" name="evaluation" value="voter">
            </form>
            <?php if ($mine) { ?>
            <a href="<?php echo 'edit-video.php?id='.$video->id; ?>" target="_blank"><i class="fas fa-cog"></i></a>
            <a href="<?php echo 'moderate-video.php?id='.$video->id; ?>" target="_blank"><i class="fas fa-user-cog"></i></a>
            <?php } ?>
          </div>
          <div class="info">
            <p><?php echo $video->description; ?></p>
          </div>
        </div>
      </section>
      <?php showError($infoErrors); ?>
      <section class="comment">
        <form method="POST" action="<?php echo $formAction; ?>">
          <textarea rows="4" placeholder="Ajouter un commentaire ..." name="comment_value"></textarea>
          <div class="com-add">
            <input type="submit" name="comment_submit" value="Publier">
          </div>
        </form>

        <?php
        if (empty($com)) {
          showInfo("Aucun commentaire n'est disponible pour le moment.");
        } else {
          foreach ($com as $comContent) {
            if (isset($commentRemoveID) && $commentRemoveID == $comContent['id_commentaire']) {
              showInfo('<a href="'.$formAction.'&rc='.$comContent['id_commentaire'].'">Cliquez-ici</a> pour confirmer la suppression du commentaire.');
            }
        ?>
        <article class="flex item" id="<?php echo $comContent['id_commentaire']; ?>">
          <img class="user" src="images/user.png" alt="Logo user">
          <div class="flex col">
            <span><?php echo $member->getPseudoByID($infoErrors, $comContent['fk_compte']); ?></span>
            <span>Date: <?php echo retrieveDate(strtotime($comContent['date_publication'])); ?></span>
            <p><?php echo $comContent['commentaire']; ?></p>
          </div>
          <?php if ($comContent['fk_compte'] == $_SESSION['account']['id']) { ?>
          <form class="remove" method="POST" action="<?php echo $formAction.'#'.$comContent['id_commentaire']; ?>">
            <input type="number" name="comment_remove" value="<?php echo $comContent['id_commentaire']; ?>" hidden>
            <button><i class="far fa-trash-alt"></i></button>
          </form>
          <?php } ?>
        </article>
        <?php
          }
        }
        ?>

      </section>
    </section>
  </main>

  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>