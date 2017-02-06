<?php
  class artiste {

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

    public function hydrate($donnees) {
      foreach ($donnees as $attribut => $valeur) {
        $methode = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
          if (is_callable(array($this, $methode))) {
            $this->$methode($valeur);
          }
      }
    }

}
