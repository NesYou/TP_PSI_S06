<?php
  function get_commentaire($connexion) {
    try {
      $requeteCommentaires = <<<SQL
      SELECT * FROM Commentaire
      ORDER by datePost
SQL;

    $resultat = $connexion->prepare($requeteCommentaires);
    $resultat->execute();

    $commentaires = $resultat->fetchALL();
    return $commentaires;

    }
    catch(Exception $e) {
      die('Erreur: '.$e->getMessage());
    }
  }
