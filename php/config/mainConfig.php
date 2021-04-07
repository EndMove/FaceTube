<?php
/**
 * This CONFIG file is the property of Jérémi N 'EndMove' <contact@endmove.eu>
 * © Copyrights 2021 EndMove, All Rights Reserved
 * Version: 1.0.0
 */

const CONFIG = array(
  "websiteName"           => "FaceTube",          # Nom du site web
  "websiteFolder"         => "/HELMo/FaceTube",   # Dossier dans lequel ce trouve le site
  "email" => array(                               # Configuration des Emails
    // Globale
    "charset"             => "UTF-8",
    "senderemail"         => "contact@endmove.eu",
    "sendername"          => "FaceTube",
    "replyemail"          => "contact@endmove.eu",
    "replyname"           => "EndMove développeur de FaceTube",
    // SMTP
    "smtpenabled"         => true,
    "smtpencryption"      => "tls",
    "smtpauthentication"  => true,
    "smtphost"            => "mail31.lwspanel.com",
    "smtpusername"        => "contact@endmove.eu",
    "smtppassword"        => 'wZ7$jn4xPM',
    "smtpport"            => 587,
    "smtpdebug"           => false,
  )
);