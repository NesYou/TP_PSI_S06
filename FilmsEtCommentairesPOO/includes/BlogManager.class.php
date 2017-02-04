<?php
  require_once('film.class.php');
  require_once('commentaire.class.php');
  require_once('artiste.class.php');
  require_once('acteur.class.php');

  public class BlogManager {

    private $db;

    public function __construct($db) {
      $this->setDb($db);
    }

    public function setDb(PDO $db) {
      $this->db = $db;
    }

    public function getListFilm() {
      $requete=<<<SQL
      SELECT film.id, titre
      , dateSortie
      , genre, origine, resume
      , prenom, nom
      FROM film JOIN artiste ON artiste.id = idMES
      ORDER BY dateSortie DESC
SQL;
      $resultat = $db->prepare($requete);
      $resultat->execute();
      while($film = $resultat->fetch()):
        $artiste = new artiste($film['idMES'], $film['prenom'], $film['nom']);
        $films[] = new film(
          $id=>$film['id'],
          $titre=>$film['titre'],
          $dateSortie=>$film['dateSortie'],
          $genre=>$film['genre'],
          $origine=>$film['origine'],
          $resume=>$film['resume'],
          $idMES=>$artiste.id,
          $prenom=>$artiste.prenom,
          $nom=>$artiste.nom
        );


      return $films;
    }
  }
