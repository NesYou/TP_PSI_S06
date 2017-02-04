<?php
  public class artiste {

    private $id;
    private $prenom;
    private $nom;


    //==================== Accesseurs ====================
    public function getId() { return $this->id; }
    public function getPrenom() { return $this->prenom; }
    public function getNom() { return $this->nom; }

    //==================== Mutateurs ====================
    public function setId($id) { $this->id = $id; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setNom($nom) { $this->nom = $nom; }

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
