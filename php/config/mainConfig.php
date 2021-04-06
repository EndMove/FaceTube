<?php
/**
 * This CONFIG file is the property of Jérémi N 'EndMove' <contact@endmove.eu>
 * © Copyrights 2021 EndMove, All Rights Reserved
 * Version: 1.0.0
 */

const CONFIG = array(
  "websiteName" => "FaceTube",                        # Nom du site web
  "websiteFolder" => "/HELMo/FaceTube",               # Dossier dans lequel ce trouve le site
  "smtpAuth" => array(                                # Configuration SMTP
    "smtpactived" => false,
    "smtpauthentication" => true,
    "smtpcharset" => "UTF-8",
    "smtpencryption" => "tls",
    "smtphost" => "###",
    "smtpusername" => "###",
    "smtppassword" => '###',
    "smtpport" => 587,
    "smtpsetfrom" => "###",
    "smtpsetfromname" => "FaceTube"
  )
);