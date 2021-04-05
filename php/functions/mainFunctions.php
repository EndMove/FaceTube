<?php

// fonction pour gérer +/- proprement les quelques erreurs
function addError($e, &$errArray = array()) {
  if (is_object($e)) {
    $errArray[] = array(
      'affichable' => true,
      'message' => $e->getMessage(),
      'file' => $e->getFile(),
      'line' => $e->getLine(),
      'code' => $e->getCode()
    );
  } elseif (is_string($e)) {
    $errArray[] = array(
      'affichable' => true,
      'message' => $e
    );
  }
  return $errArray;
}

// une fonction d'affichage
function showError($errArray) {

}