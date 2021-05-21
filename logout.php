<?php
include("core.php");

session_destroy();
setcookie("PHPSESSID", "", time()-3600, CONFIG['websiteFolder']);
if (isset($_GET['rc'])) {
  header('Location: ' . getRootUrl(true) . '?msg=rc');
} else {
  header('Location: ' . getRootUrl(true));
}
die();