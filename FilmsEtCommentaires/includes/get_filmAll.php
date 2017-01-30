<?php
  function get_filmAll($connexion) {
    try {
      $requete=<<<SQL
      SELECT film.id, titre
      , dateSortie
      , genre, origine, resume
      , prenom, nom
      FROM film JOIN artiste ON artiste.id = idMES
      ORDER BY dateSortie DESC
SQL;
      $resultat = $connexion->prepare($requete);
      $resultat->execute();

      $films = $resultat->fetchALL();
      return $films;
    }
    catch(Exception $e) {
      die('Erreur: '.$e->getMessage());
    }
  }
