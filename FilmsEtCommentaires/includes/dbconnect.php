<?php
function connect() {
  try{
    $connexion = new PDO('mysql:host=localhost; dbname=blog_filmEtCommentaire', 'root', '');
    $connexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connexion;
  }
  catch(Exception $e) {
    die('Erreur: '.$e->getMessage());
  }
}
