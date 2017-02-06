<?php
  require_once ('film.class.php');
  require_once ('artiste.class.php');

  class acteur {

    private $idActeur;
    private $idFilm;

    //==================== Accesseurs ====================
    public function getIdActeur() { return $this->idActeur; }
    public function getIdFilm() { return $this->idFilm; }

    //==================== Mutateurs ====================
    public function setIdActeur(artiste $id) { $this->idActeur = $id; }
    public function setIdFilm(film $idFilm) { $this->idFilm = $idFilm; }

    public function __construct(array $donnees) {
      $this->hydrate($donnees);
    }

    public function hydrate($donnees) {
      foreach ($donnees as $attribut => $valeur) {
        $methode = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
        if (is_callable(array($this, $methode))) {
          $this->$methode($valeur);
        }
      }
   }

  }
