<?php
function connect() {
  try{
    $connexion = new PDO('mysql:host=localhost; dbname=releve_mensuel', 'root', '', array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connexion;
  }
  catch(Exception $e) {
    die('Erreur: '.$e->getMessage());
  }
}
