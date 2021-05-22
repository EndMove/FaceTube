<?php
include("php/includes/pages/moderate-channel.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Modérer chaîne</title>
  <!-- End Header -->
</head>
<body>
<header>
  <!-- Nav -->
  <?php include("php/includes/nav.inc.php"); ?>
  <!-- End Nav -->
</header>

<main>
  <h1 class="text-center">Modérer une chaîne</h1>
  <?php showError($infoErrors); showSuccess($infoSucc); ?>
  <form id="form" method="POST" action="<?php echo $formAction; ?>">
    <div class="field">
      <label for="blocked">Le statut de la chaîne ?</label>
      <select id="blocked" name="blocked" required>
        <option value="">== Choisi une option ==</option>
        <option value="blocked" <?php echo $block ? 'selected' : ''; ?>>Bloqué</option>
        <option value="unblocked" <?php echo $block ? '' : 'selected'; ?>>Débloqué</option>
      </select>
    </div>
    <div class="split">
      <div class="field"></div>
      <div class="field btn text-right">
        <input type="submit" name="submit" value="Enregistrer">
      </div>
    </div>
  </form>
</main>

<!-- Footer -->
<?php include("php/includes/footer.inc.php"); ?>
<!-- End Footer -->
</body>
</html>