<?php
include("php/includes/pages/edit-video.inc.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Header -->
  <?php include("php/includes/head.inc.php"); ?>
  <title><?php echo CONFIG['websiteName'] ?> | Éditer vidéo</title>
  <!-- End Header -->
</head>
<body>
  <header>
    <!-- Nav -->
    <?php include("php/includes/nav.inc.php"); ?>
    <!-- End Nav -->
  </header>

  <main>
    <h1 class="text-center">Ajouter ou modifier une vidéo</h1>
    <?php showError($infoErrors); showSuccess($infoSucc);
    if (isset($_POST['remove']) && isset($id)) {
      showInfo('<a href="' . $formAction . '&rv=true">Cliquez-ici</a> pour confirmer la suppression de cette vidéo.');
    }
    ?>
    <form id="form" method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data">
      <div class="field">
        <label for="channel">Chaîne de publication</label>
        <select id="channel" name="channel" required>
          <option value="">== Choisi une option ==</option>
        <?php foreach ($channels as $ch) { ?>
          <option value="<?php echo $ch->id; ?>" <?php echo (isset($fk_channel) && $fk_channel == $ch->id) ? 'selected' : ''; ?>><?php echo $ch->name; ?></option>
        <?php } ?>
        </select>
      </div>
      <div class="field">
        <label for="title" class="required">Titre</label><input type="text" id="title" name="title" placeholder="Titre de la vidéo" value="<?php echo isset($title) ? $title : ''; ?>" required>
      </div>
      <div class="field">
        <label for="description" class="required">Description</label><textarea id="description" name="description" rows="5"><?php echo isset($description) ? $description : ''; ?></textarea>
      </div>
      <div class="field">
        <label for="html_fragment" class="required">HTML5 Fragment</label><input type="text" id="html_fragment" name="html_fragment" placeholder="<iframe>...</iframe>" value='<?php echo isset($fragment) ? htmlspecialchars_decode($fragment) : ''; ?>' required>
      </div>
      <div class="field">
        <label for="time" class="required">Durée vidéo (hh:mm:ss)</label><input type="time" id="time" step="1" name="time" value="<?php echo isset($duration) ? $duration : ''; ?>" required>
      </div>
      <div class="field">
        <label for="banner" class="required">Mignature</label><input type="file" id="banner" name="banner" required>
      </div>
      <div class="split">
        <div class="field"></div>
        <div class="field btn text-right">
          <input type="submit" name="submit" value="Enregistrer">
        </div>
      </div>
    </form>

    <?php if (isset($id)) { ?>
    <div class="flex jsf-center">
      <form method="POST" action="<?php echo $formAction; ?>">
        <input class="red" type="submit" name="remove" value="(!) Supprimer la Vidéo (!)">
      </form>
    </div>
    <?php } ?>
  </main>
  
  <!-- Footer -->
  <?php include("php/includes/footer.inc.php"); ?>
  <!-- End Footer -->
</body>
</html>