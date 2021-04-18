<?php
include("php/includes/pages/home.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Accueil</title>
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

    <?php foreach ($homeData as $data) { ?>
    <section>
      <h2>De la chaine <u><a href="<?php echo('channel.php?id=' . $data['ch']['id']); ?>"><?php echo $data['ch']['name']; ?></a></u></h2>
      <?php
      if (empty($data['vi'])) {
        showInfo("Cette chaine ne contien aucune vidéo pour le moment.");
      } else {
      ?>
      <div class="flex wrap">
        <?php foreach ($data['vi'] as $video) { ?>
        <article class="video-item">
          <a class="to-video" href="<?php echo 'video.php?id=' . $video['id']; ?>">
            <img class="mignature" src="<?php echo(getFileUrl($video['miniature'])); ?>" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="<?php echo('video.php?id=' . $video['id']); ?>"><h3><?php echo $video['title']; ?></h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="<?php echo('channel.php?id=' . $data['ch']['id']); ?>"><?php echo $data['ch']['name']; ?></a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> <?php echo($video['views']); ?></span>
                  <span><i class="far fa-clock"></i> <?php echo($video['duration']); ?></span>
                </div>
              </div>
            </div>
          </div>
        </article>
        <?php } ?>
      </div>
      <?php } ?>
    </section>
    <?php } ?>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>