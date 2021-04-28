<?php
include("core.php");

session_destroy();
setcookie("PHPSESSID", "", time()-3600, CONFIG['websiteFolder']);
header('Location: ' . getRootUrl(true));
die();