<?php
  class commentaire {

    private $id;
    private $idFilm;
    private $auteur;
    private $datePost;
    private $contenu;


    //==================== Accesseurs ====================
    public function getId() { return $this->id; }
    public function getIdFilm() { return $this->idFilm; }
    public function getAuteur() { return $this->auteur; }
    public function getDatePost() { return $this->datePost; }
    public function getContenu() { return $this->contenu; }


    //==================== Mutateurs ====================
    public function setId($id) { $this->id = $id; }
    public function setIdFilm($idFilm) { $this->idFilm = $idFilm; }
    public function setAuteur($auteur) { $this->auteur = $auteur; }
    public function setDatePost($datePost) { $this->datePost = $datePost; }
    public function setContenu($contenu) { $this->contenu = $contenu; }

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
