<?php
  function get_acteurAll($connexion, $idFilm) {
    try {
      $requeteActeurs = <<<SQL
        SELECT nom, prenom
        FROM Acteur
        INNER JOIN Artiste ON idActeur = Artiste.id
        INNER JOIN Film WHERE Acteur.idFilm = Film.id
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
