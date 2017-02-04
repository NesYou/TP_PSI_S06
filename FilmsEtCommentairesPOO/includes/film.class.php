<?php

  require_once('artiste.class.php');

  public class film {

    private $id;
    private $idMES;
    private $titre;
    private $dateSortie;
    private $genre;
    private $origine;
    private $resume;

    //==================== Accesseurs ====================
    public function getId() { return $this -> id; }
    public function getIdMES() { return $this -> idMES; }
    public function getTitre() { return $this -> titre; }
    public function getDateSortie() { return $this -> dateSortie; }
    public function getGenre() { return $this -> genre; }
    public function getOrigine() { return $this -> origine; }
    public function getResume() { return $this -> resume; }

    //==================== Mutateurs ====================
    public function setId($id) { $this -> $id = id; }
    public function setIdMES(artiste $idMES) { $this -> $idMES = idMES; }
    public function setTitre($titre) { $this -> $titre = titre; }
    public function setDateSortie($dateSortie) { $this -> $dateSortie = dateSortie; }
    public function setGenre($genre) { $this -> $genre = genre; }
    public function setOrigine($origine) { $this -> $origine = origine; }
    public function setResume($resume) { $this -> $resume = resume; }



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

    private function is_date($date, $format='Y-m-d'){
      $d = date_create_from_format($format,$date);
      return($d && $d->format($format)==$date);
    }
  }
