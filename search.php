<?php
include("php/includes/pages/search.inc.php");

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Objet Chaine
$member = new member\Member($bdd);
$video = new video\Video($bdd);

$member->import($infoErrors, $_SESSION['account']['id']);

if (isset($_POST['query'])) {
  $query = secure::string($_POST['query']);
  $idFriends = array();

  if (($friends = $member->getFriendList($infoErrors)) != 'none') {
    foreach($friends as $val) {
      $idFriends[] = $val['id'];
    }
  }
  $data = $video->search($infoErrors, $query, $idFriends);
} else {
  header('Location: ' . getRootUrl(true) . '/profile.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Rechercher</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Rechercher</h1>
    <form id="search-bar" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="text" id="query" name="query" placeholder="Rechercher par mot clé...">
      <button><i class="fas fa-search"></i></button>
    </form>
    <?php showSuccess($infoSucc); showError($infoErrors); ?>
    <section id="search-video" class="flex col">

    <?php
    if (empty($data)) {
      showInfo("Aucun résultat pour votre recherche");
    } else {
      foreach ($data as $vi) { ?>
      <article class="video-item">
        <a class="to-video" href="<?php echo('video.php?id=' . $vi->id); ?>">
          <img class="mignature" src="<?php echo(getFileUrl($vi->miniature)); ?>" alt="mignature">
        </a>
        <div class="flex row">
          <a href="<?php echo('channel.php?id=' . $vi->fk_channel); ?>"><img class="user" src="images/user.png" alt="Logo Chaine"></a>
          <div class="flex col">
            <div class="title">
              <a href="<?php echo('video.php?id=' . $vi->id); ?>"><h3><?php echo $vi->title; ?></h3></a>
            </div>
            <div class="sub-title">
              <a class="link" href="<?php echo('channel.php?id=' . $vi->fk_channel); ?>">VISITER LA CHAÎNE DE L'AUTEUR</a>
              <div class="meta">
                <span><i class="far fa-eye"></i> <?php echo($vi->views); ?></span>
                <span><i class="far fa-star"></i> <?php echo($vi->evaluation); ?></span>
                <span><i class="far fa-comments"></i> <?php echo($vi->comment); ?></span>
                <span><i class="far fa-clock"></i> <?php echo($vi->duration); ?></span>
              </div>
            </div>
            <div class="description">
              <p><?php echo $vi->description; ?></p>
            </div>
          </div>
        </div>
      </article>
      <?php
        }
      }
      ?>
    </section>
<!--    <section>
      <nav class="pagination">
        <ul class="jsf-end">
          <li><a href="#"><i class="fas fa-chevron-left"></i></a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
        </ul>
      </nav>
    </section>-->
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>