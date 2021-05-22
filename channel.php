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

    <section>
      <div class="flex action-button">
        <h2>Vidéos de la chaîne</h2>
        <?php echo (!$channel->ispublic) ? '<p>(Privée)</p>' : ''; ?>
        <?php if ($mine) { ?>
          <a href="<?php echo 'edit-channel.php?id=' . $channel->id; ?>" target="_blank"><i class="fas fa-edit"></i></a>
          <a href="<?php echo 'edit-video.php?ch=' . $channel->id; ?>"><i class="fas fa-plus"></i></a>
        <?php }
        if (isAdmin()) { ?>
          <a href="<?php echo 'moderate-channel.php?id=' . $channel->id; ?>" target="_blank"><i class="fas fa-user-cog"></i></a>
        <?php } ?>
      </div>

      <?php showSuccess($infoSucc); showError($infoErrors); ?>

      <div class="flex wrap">
    <?php
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
                <a href="<?php echo('video.php?id=' . $vi->id); ?>"><h3 <?php if ($vi->isblocked) {echo 'class="admin-txt"';} ?>><?php echo $vi->title;?></h3></a>
              </div>
              <div class="sub-title">
                <a class="link" href="<?php echo('channel.php?id=' . $channel->id); ?>"><?php echo $channel->name; ?></a>
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
        
      </div>

    </section>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>