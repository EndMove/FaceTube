<nav class="main">
      <ul>
        <li class="banner">
          <a href="home.php">
            <img src="images/FaceTube-logo.png" alt="logo">
            <span>FaceTube</span>
          </a>
        </li>
        <!--<li><a href="home.php" <?php if($page=='home') echo 'class="active"'; ?>>Accueil</a></li>-->
        <li>
          <a href="search.php" <?php if($page=='search') echo 'class="active"'; ?>>Rechercher</a>
        </li>
        <li>
          <a href="contact.php" <?php if($page=='contact') echo 'class="active"'; ?>>Contact</a>
        </li>
        <li>
          <a href="about.php" <?php if($page=='about') echo 'class="active"'; ?>>À propos</a>
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
