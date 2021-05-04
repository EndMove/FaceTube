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
      <input type="text" id="query" name="query" placeholder="Rechercher...">
      <button><i class="fas fa-search"></i></button>
    </form>

    <section id="video">
      <section class="content">
        <?php echo htmlspecialchars_decode($video->fragment); ?>
      </section>

      <section class="meta">
        <h1><?php echo $video->title; ?></h1>
        <div class="flex wrap">
          <div class="stats">
            <span><i class="far fa-eye"></i> <?php echo $video->views ?></span>
            <span><i class="far fa-clock"></i> <?php echo $video->duration; ?></span>
            <span><i class="far fa-comments"></i> 000k</span>
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

      <section class="comment">
        <form>
          <textarea rows="4" placeholder="Ajouter un commentaire ..." name="comment_value"></textarea>
          <div class="com-add">
            <input type="submit" name="comment_submit" value="Publier">
          </div>
        </form>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Dans League of Legends, le joueur contrôle un champion aux compétences uniques dont la puissance augmente au fil de la partie se battant contre une équipe de joueurs en temps réel la plupart du temps. L'objectif d'une partie est, dans la quasi-totalité des modes de jeu, de détruire le « Nexus » ennemi, bâtiment situé au cœur de la base adverse protégé par des tourelles et inhibiteurs. Le jeu comporte un grand nombre de similitudes avec Defense of the Ancients de par le fait que la majorité des premiers développeurs de League of Legends n'étaient autres que les créateurs de DotA. (source: https://fr.wikipedia.org/wiki/League_of_Legends)</p>
          </div>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user.png" alt="Logo user">
          <div class="flex col">
            <span>EndMoveMovie</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
          <form>
            <input type="number" name="comment_remove" value="1" hidden>
            <button><i class="far fa-trash-alt"></i></button>
          </form>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user.png" alt="Logo user">
          <div class="flex col">
            <span>EndMoveMovie</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
          <form>
            <input type="numeric" name="comment_remove" value="1" hidden>
            <button><i class="far fa-trash-alt"></i></button>
          </form>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </article>

        <article class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </article>
      </section>
    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>