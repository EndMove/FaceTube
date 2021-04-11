<?php
include("php/includes/pages/edit-video.inc.php");

// Variable d'information sur les erreurs, succès.
$infoErrors = array();
$infoSucc   = '';

// Objet Chaine
$channel = new video\Channel($bdd);

// Variable par défaut
$public = false;
$name = NULL;

// Récupérer toute les chaines
$channels = $channel->exportAll($infoErrors, $_SESSION['account']['id']);

// Option GET - Charger vidéo; Supprimer vidéo.
if (isset($_GET['id'])) {
  $id = secure::int($_GET['id']);

  // Options
  if (isset($_GET['option'])) {
    $option = secure::string($_GET['option']);
    switch ($option) {
      case 'remove':
        // une action
        break;
      default:
        addError("Option inconnue merci de vérifier votre requète HTTP", $infoErrors);
        break;
    }
  }
}

// Option POST (mettre à jour chaine || créer chaine).
if (isset($_POST['submit'])) {
  $name = secure::string($_POST['name']);
  $public = secure::string($_POST['public']) == 'public';

  $data = array(
    'fk_owner' => $_SESSION['account']['id'],
    'name' => $name,
    'ispublic' => $public
  );

  $channel->setData($data);

  if (isset($id)) {
    // Mise à jour
    if ($channel->update($infoErrors)) {
      $infoSucc = 'Mise à jour de la chaine réussie';
    }
  } else {
    // Créer
    if ($channel->create($infoErrors)) {
      $infoSucc = 'Création de la chaine réussie';
    }
  }
}
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
    <form id="form" method="POST" action="" enctype="multipart/form-data">
      <div class="field">
        <label for="channel">Chaîne de publication</label>
        <select id="channel" name="channel">
          <option value="#">K/DA</option>
          <option value="#">EndMoveMovie</option>
        </select>
      </div>
      <div class="field">
        <label for="title">Titre</label><input type="text" id="title" name="title" placeholder="Titre de la vidéo" value="MORE (avec Lexie Liu, Jaira Burns, Seraphine et League of Legends)">
      </div>
      <div class="field">
        <label for="description">Description</label><textarea id="description" name="description" value="Contenu" rows="5">Montez sur le trône. K/DA est de retour avec « MORE », qui regroupe Madison Beer, SOYEON et MIYEON de (G)I-DLE, Lexie Liu, Jaira Burns et Séraphine. K/DA est un super-groupe musical composé d'Ahri, Evelynn, Akali et Kai'Sa. Ne manquez pas leur prochain EP, ALL OUT, qui paraîtra le 6 novembre 2020. Suivez l'actualité de @KDA_MUSIC sur Twitter et Instagram.</textarea>
      </div>
      <div class="field">
        <label for="html_fragment">HTML5 Fragment</label><input type="text" id="html_fragment" name="html_fragment" placeholder="https://####.##" value="https://www.youtube.com/embed/3VTkBuxU4yk">
      </div>
      <div class="field">
        <label for="time">HTML5 Fragment</label><input type="time" id="time" name="time" placeholder="00:15:00" value="00:00">
      </div>
      <div class="field">
        <label for="banner">Mignature</label><input type="file" id="banner" name="banner" placeholder="https://####.##/####.##" value="upload/mignature02.webp">
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