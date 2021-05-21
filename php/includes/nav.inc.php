<nav class="main">
      <ul>
        <li class="banner">
          <a href="home.php">
            <img src="images/FaceTube-logo.png" alt="logo">
            <span>FaceTube</span>
          </a>
        </li>
        <?php if(isConnected()) { ?>
        <li>
          <a href="profile.php" <?php if($page=='profile') echo 'class="active"'; ?>>Profil</a>
        </li>
        <li>
          <a href="friends.php" <?php if($page=='friends') echo 'class="active"'; ?>>Vos amis</a>
        </li>
        <li>
          <a href="edit-channel.php" <?php if($page=='edit-channel') echo 'class="active"'; ?>>Ajouter chaîne</a>
        </li>
        <li>
          <a href="edit-video.php" <?php if($page=='edit-video') echo 'class="active"'; ?>>Ajouter vidéo</a>
        </li>
        <?php } ?>
        <li>
          <a href="contact.php" <?php if($page=='contact') echo 'class="active"'; ?>>Contact</a>
        </li>
      <?php if (isConnected()) { ?>
        <li class="align-right">
          <a href="myaccount.php" <?php if($page=='account') echo 'class="active"'; ?>><?php echo($_SESSION['account']['firstname'].' '.$_SESSION['account']['lastname']); ?></a>
        </li>
        <li class="red">
          <a href="logout.php">Déconnexion</a>
        </li>
      <?php } else { ?>
        <li class="align-right">
          <a href="index.php" <?php if($page=='login') echo 'class="active"'; ?>>Connexion</a>
        </li>
        <li>
          <a href="register.php" <?php if($page=='register') echo 'class="active"'; ?>>Inscription</a>
        </li>
      <?php } ?>
      </ul>
    </nav>
