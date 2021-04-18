<?php
/**
 * This CONFIG file is the property of Jérémi N 'EndMove' <contact@endmove.eu>
 * © Copyrights 2021 EndMove, All Rights Reserved
 * Version: 1.0.0
 */

const CONFIG = array(
  "websiteName"           => "FaceTube",          # Nom du site web.
  "websiteFolder"         => "/HELMo/FaceTube",   # Dossier dans lequel ce trouve le site.
  "websiteTimezone"       => "Europe/Paris",      # Time zone du site web pour les dates.
  "websiteDateformat"     => "d/m/Y H:i",         # Format de la date par defaut.
  "email" => array(                               # Configuration des Emails.
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
  ),
  "file" => array(                                # Configuration des fichiers.
    "uploadfolder" => "/upload",
    "maximumsize" => 1500000,
    "pathallowed" => array(
      "jpg" => "image/jpg",
      "jpeg" => "image/jpeg",
      "png" => "image/png"
    )
  )
);