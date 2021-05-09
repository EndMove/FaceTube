<?php
include("php/includes/pages/profile.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Profile</title>
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
          <li>Chaînes de <b><?php echo($member->firstname.' '.$member->lastname); ?></b></li>
        </ul>
      </div>
      <div class="align-right">
        <h1>Profil de <b><?php echo $member->login; ?></b></h1>
      </div>
    </div>

    <?php showError($infoErrors); showSuccess($infoSucc); ?>

    <?php
    if ($channels !== false) {
      foreach ($channels as $ch) {
        $infoErrors = array();
        $videos = $video->exportAll($infoErrors, $ch->id, [0,5]);
    ?>
    <section>
      <div class="flex action-button">
        <h2>Chaîne: <?php echo $ch->name; ?></h2>
        <?php echo (!$ch->ispublic) ? '<p>(Privée)</p>' : ''; ?>
        <?php if ($mine) { ?>
        <a href="<?php echo 'edit-channel.php?id=' . $ch->id; ?>" target="_blank"><i class="fas fa-edit"></i></a>
        <a href="<?php echo 'edit-channel.php?id=' . $ch->id . '&option=remove'; ?>"><i class="fas fa-trash-alt"></i></a>
        <?php } ?>
      </div>
      <div class="flex wrap">

        <?php
        showError($infoErrors);
        if ($videos !== false) {
          foreach ($videos as $vi) {
        ?>
        <article class="video-item">
          <a class="to-video" href="<?php echo 'video.php?id=' . $vi->id; ?>">
            <img class="mignature" src="<?php echo(getFileUrl($vi->miniature)); ?>" alt="mignature">
          </a>
          <div class="flex row">
            <a href="channel.php"><img class="user" src="images/user.png" alt="Logo Chaine"></a>
            <div class="flex col">
              <div class="title">
                <a href="<?php echo('video.php?id=' . $vi->id); ?>"><h3><?php echo $vi->title; ?></h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="<?php echo('channel.php?id=' . $ch->id); ?>"><?php echo $ch->name; ?></a>
                <div class="meta">
                  <span><i class="far fa-eye"></i> <?php echo($vi->views); ?></span>
                  <span><i class="far fa-star"></i> <?php echo($vi->evaluation); ?></span>
                  <span><i class="far fa-comments"></i> <?php echo($vi->comment); ?></span>
                  <span><i class="far fa-clock"></i> <?php echo($vi->duration); ?></span>
                </div>
              </div>
            </div>
          </div>
        </article>
        <?php
          }
        }
        ?>

        <div class="video-item see-more">
          <a href="<?php echo getRootUrl(true) . '/channel.php?id=' . $ch->id; ?>">
            <div class="content">
              <i class="fas fa-plus-circle"></i>
              <span>Voir la Chaîne</span>
            </div>
          </a>
        </div>
        
      </div>
    </section>
    <?php
      }
    }
    ?>

  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>