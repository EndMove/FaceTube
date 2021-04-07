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
    <form id="search-bar" method="POST">
      <input type="text" id="query" name="query" placeholder="Rechercher...">
      <button><i class="fas fa-search"></i></button>
    </form>

    <section id="video">
      <section class="content">
        <iframe src="https://www.youtube.com/embed/3VTkBuxU4yk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </section>

      <section class="meta">
        <h2>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h2>
        <div class="flex wrap">
          <div class="stats">
            <span><i class="far fa-eye"></i> 485k</span>
            <span><i class="far fa-clock"></i> 20:15</span>
            <span><i class="far fa-comments"></i> 541k</span>
          </div>
          <div class="flex options">
            <span class="noflex"><i class="far fa-star"></i> 47%</span>
            <form method="POST">
              <input type="text" name="like" hidden>
              <button class="active"><i class="far fa-thumbs-up"></i></button>
            </form>
            <form method="POST">
              <input type="text" name="dislike" hidden>
              <button><i class="far fa-thumbs-down"></i></button>
            </form>
            <a href="edit-video.php" target="_blank"><i class="fas fa-cog"></i></a>
            <a href="moderate-video.php" target="_blank"><i class="fas fa-user-cog"></i></a>
          </div>
          <div class="info">
            <p>Montez sur le trône. K/DA est de retour avec « MORE », qui regroupe Madison Beer, SOYEON et MIYEON de (G)I-DLE, Lexie Liu, Jaira Burns et Séraphine. K/DA est un super-groupe musical composé d'Ahri, Evelynn, Akali et Kai'Sa. Ne manquez pas leur prochain EP, ALL OUT, qui paraîtra le 6 novembre 2020. Suivez l'actualité de @KDA_MUSIC sur Twitter et Instagram.</p>
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

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur <div></div></span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Dans League of Legends, le joueur contrôle un champion aux compétences uniques dont la puissance augmente au fil de la partie se battant contre une équipe de joueurs en temps réel la plupart du temps. L'objectif d'une partie est, dans la quasi-totalité des modes de jeu, de détruire le « Nexus » ennemi, bâtiment situé au cœur de la base adverse protégé par des tourelles et inhibiteurs. Le jeu comporte un grand nombre de similitudes avec Defense of the Ancients de par le fait que la majorité des premiers développeurs de League of Legends n'étaient autres que les créateurs de DotA. (source: https://fr.wikipedia.org/wiki/League_of_Legends)</p>
          </div>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user.png" alt="Logo user">
          <div class="flex col">
            <span>EndMoveMovie</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
          <form>
            <input type="numeric" name="comment_remove" value="1" hidden>
            <button><i class="far fa-trash-alt"></i></button>
          </form>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user.png" alt="Logo user">
          <div class="flex col">
            <span>EndMoveMovie</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
          <form>
            <input type="numeric" name="comment_remove" value="1" hidden>
            <button><i class="far fa-trash-alt"></i></button>
          </form>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </div>

        <div class="flex item">
          <img class="user" src="upload/user2.jpg" alt="Logo user">
          <div class="flex col">
            <span>Nom d'utilsateur</span>
            <p>Ceci est un commentaire, il pourrait être long ou court ! J'aime cette vidéo ou pas. J'écrit pour ne rien dire LMAO = L(augh)M(y)A(ss)O(ff)</p>
          </div>
        </div>
      </section>
    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>