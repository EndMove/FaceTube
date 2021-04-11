<?php
include("php/includes/pages/channel.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Chaine</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <div class="sub-header">
      <div class="breadcrumb">
        <ul>
          <li><a href="home.php">Accueil</a></li>
          <li><a href="<?php echo 'profile.php?id=' . $member->id; ?>">Chaînes de <b><?php echo($member->firstname.' '.$member->lastname); ?></b></a></li>
          <li><b><?php echo $channel->name; ?></b></li>
        </ul>
      </div>
      <div class="align-right">
      	<h1>Chaîne de <b><?php echo $member->login; ?></b></h1>
      </div>
    </div>

    <?php showError($infoErrors); showSuccess($infoSucc); ?>

    <section>
      <h2>Vidéos de la chaîne</h2>

      <div class="flex wrap">

        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>

        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>
        
        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>
        
        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>
        
        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>

        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>

        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>

        <article class="video-item">
          <a class="to-video" href="video.php">
            <img class="mignature" src="upload/mignature02.webp" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="upload/user2.jpg" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="video.php"><h3>MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)</h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="channel.php">K/DA</a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> 485k</span>
                  <span><i class="far fa-clock"></i> 20:15</span>
                </div>
              </div>
            </div>
          </div>
        </article>
        
      </div>

    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>