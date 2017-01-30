<?php
  function get_acteurAll($connexion) {
    try {
      $requeteActeurs = <<<SQL
        SELECT nom, prenom, idFilm
        FROM Acteur
        INNER JOIN Artiste ON idActeur = Artiste.id
SQL;

      $resultat = $connexion->prepare($requeteActeurs);
      $resultat->execute();

      $acteurs = $resultat->fetchALL();
      return $acteurs;
    }
    catch(Exception $e) {
      die('Erreur: '.$e->getMessage());
    }
  }
 ?>
