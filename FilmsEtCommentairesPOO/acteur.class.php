<?php
  require_once('film.class.php');
  require_once('artiste.class.php');

  class acteur {

    private $id;
    private $idFilm;

    //==================== Accesseurs ====================
    public function getId() { return $this->id; }
    public function getIdFilm() { return $this->idFilm; }

    //==================== Mutateurs ====================
    public function setId(artiste $id) { $this->id = $id; }
    public function setIdFilm(film $idFilm) { $this->idFilm = $idFilm; }

    public function __construct(array $donnees) {
      $this->hydrate($donnees);
    }

    public function hydrate(array $donnees) {
      foreach ($donnees as $key => $value):
        $method = 'set' . ucfirst($key);
        if (method_exists($this, $method)):
          $this->$method($value);
        endif;
      endforeach;
    }

  }
