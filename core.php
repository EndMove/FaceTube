<?php
/**
 * This CORE file is the property of Jérémi N 'EndMove' <contact@endmove.eu>
 * © Copyrights 2021 EndMove, All Rights Reserved
 * Version: 1.0.0
 */

session_start();

const ROOT = __DIR__;
include ROOT . '/php/config/mainConfig.php';

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


/*=========================================================================*
 *                                 Classes                                 *
 *=========================================================================*/

# DBManager classe
require ROOT . '/php/class/DBManager.php';

# dataUtils classe
require ROOT . '/php/class/dataUtils.php';

# Member classe
require ROOT . '/php/class/Member.php';


/*=========================================================================*
 *                  Code à exécuter sur toutes les pages                   *
 *=========================================================================*/
$errArray = array();
$bdd = db\DBManager::connect($errArray);
if (!$bdd) {
  echo "Erreur: impossible de ce connecter à la base de données";
  exit;
}
