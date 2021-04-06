<?php
include("core.php");

session_destroy();
header('Location: ' . getRootUrl(true));
die();