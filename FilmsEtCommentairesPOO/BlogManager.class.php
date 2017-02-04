<?php
  require_once('film.class.php');
  require_once('commentaire.class.php');
  require_once('artiste.class.php');
  require_once('acteur.class.php');

  class BlogManager {

    private $db;

    public function __construct($db) {
      $this->setDb($db);
    }

    public function setDb(PDO $db) {
      $this->db = $db;
    }

    public function getListFilm() {
      $requete=<<<SQL
      SELECT film.id, idMES, titre
      , dateSortie
      , genre, origine, resume
      , prenom, nom
      FROM film JOIN artiste ON artiste.id = idMES
      ORDER BY dateSortie DESC
SQL;
      $resultat = $this->db->prepare($requete);
      $resultat->execute();
      while($film = $resultat->fetch()){
        $artiste = new artiste(array($film['idMES'], $film['prenom'], $film['nom']));
        $films[] = new film(
          $id=$film['id'],
          $titre=$film['titre'],
          $dateSortie=$film['dateSortie'],
          $genre=$film['genre'],
          $origine=$film['origine'],
          $resume=$film['resume'],
          $idMES=$artiste->getId(),
          $prenom=$artiste->getPrenom(),
          $nom=$artiste->getNom()
        );
      }


      return $films;
    }
  }
