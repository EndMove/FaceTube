<?php
include("php/includes/pages/edit-channel.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Éditer chaîne</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Ajouter ou modifier une une chaîne</h1>
    <?php showError($infoErrors); showSuccess($infoSucc); ?>
    <form id="form" method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data">
      <div class="field">
        <label for="name" class="required">Le nom de la chaîne</label><input type="text" id="name" name="name" placeholder="Nom de la chaine" value="<?php echo isset($name) ? $name : ''; ?>" required>
      </div>
      <div class="field">
        <label for="public">La chaine est elle public ?</label>
        <select id="public" name="public" required>
          <option value="public" <?php echo $public ? 'selected' : ''; ?>>Publique</option>
          <option value="private" <?php echo $public ? '' : 'selected'; ?>>Privée</option>
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