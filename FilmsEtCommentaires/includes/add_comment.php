<?php
  function add_comment($connexion, $idFilm, $auteur, $contenu) {
    try {
      $addComment = <<<SQL
      INSERT INTO commentaire (idFilm, auteur, datePost, contenu)
      VALUES (?, ?, ?, ?)
SQL;
      $action = $connexion->prepare($addComment);
      $action->execute(array($idFilm, $auteur, date('Y-m-d H:i:s'), $contenu));

      return "Votre commentaire à bien été ajouté.";

    }
    catch(Exception $e) {
      die('Erreur: '.$e->getMessage());
    }
  }
