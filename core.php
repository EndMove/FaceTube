<?php
/**
 * This CORE file is the property of Jérémi N 'EndMove' <contact@endmove.eu>
 * © Copyrights 2021 EndMove, All Rights Reserved
 * Version: 1.0.0
 */

session_start();

const ROOT = __DIR__;
include ROOT . '/php/config/config.php';
date_default_timezone_set(CONFIG['websiteTimezone']);

/*=========================================================================*
 *                                Libraries                                *
 *=========================================================================*/

# PHPMailer Librairie
require ROOT . '/php/libraries/PHPMailer/src/Exception.php';
require ROOT . '/php/libraries/PHPMailer/src/PHPMailer.php';
require ROOT . '/php/libraries/PHPMailer/src/SMTP.php';


/*=========================================================================*
 *                                Fonctions                                *
 *=========================================================================*/

# Fonctions principales
require ROOT . '/php/functions/mainFunctions.php';

# Fonctions de vérification de données
require ROOT . '/php/functions/dataFunctions.php';


/*=========================================================================*
 *                                 Classes                                 *
 *=========================================================================*/

# DBManager classe
require ROOT . '/php/class/DBManager.php';

# Member classe
require ROOT . '/php/class/Member.php';

# Comment Classe
require ROOT . '/php/class/Comment.php';

# Video Classe
require ROOT . '/php/class/Video.php';

# Channel Classe
require ROOT . '/php/class/Channel.php';


/*=========================================================================*
 *                  Code à exécuter sur toutes les pages                   *
 *=========================================================================*/
$errArray = array();
$bdd = db\DBManager::connect($errArray);
if (!$bdd) {
  echo "Erreur: impossible de ce connecter à la base de données";
  exit;
}
