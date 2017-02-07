<?php
  require_once ('film.class.php');
  require_once ('commentaire.class.php');
  require_once ('artiste.class.php');
  require_once ('acteur.class.php');

  class BlogManager {

    private $db;
    
    
    public function __construct($db) { $this->setDb($db); }
    
    //==================== Accesseurs ====================
    public function setDb(PDO $db) { $this->db = $db; }
    
    //==================== Mutateurs ====================
    public function getDb() { return $this->db; }

    public function getListFilm() {
      $film=array();
      $requete=<<<SQL
      SELECT film.id, titre, idMES
      , dateSortie
      , genre, origine, resume
      , prenom, nom
      FROM film JOIN artiste ON artiste.id = idMES
      ORDER BY dateSortie DESC
SQL;
      $resultat = $this->db->prepare($requete);
      $resultat->execute();
      while($film = $resultat->fetch(PDO::FETCH_ASSOC)){
        $artiste = new artiste(array(
                                     'prenom'=>$film['prenom'],
                                     'nom'=>$film['nom']
                                    ));
        $films[] = new film(array(
                                  'id'=>$film['id'],
                                  'titre'=>$film['titre'],
                                  'dateSortie'=>$film['dateSortie'],
                                  'genre'=>$film['genre'],
                                  'origine'=>$film['origine'],
                                  'resume'=>$film['resume'],
                                  'idMES'=>$artiste
                                ));
      }
      return $films;
    }
    
    public function getActeur() {
        $lesActeurs = array();
        $requete = <<<SQL
        SELECT nom, prenom, idFilm
        FROM Acteur
        JOIN Artiste ON idActeur = Artiste.id
SQL;
        $resultat = $this->db->prepare($requete);
        $resultat->execute();
        while($data = $resultat->fetch(PDO::FETCH_ASSOC)){
            $artiste = new artiste(array(
                                        'prenom'=>$data['prenom'],
                                        'nom'=>$data['nom']
                                        ));
            $film = new film(array(                                  
                                  'id'=>$data['idFilm']
                                  ));
            $lesActeurs[] = new acteur(array(
                                            'idActeur'=>$artiste,
                                            'idFilm'=>$film
                                            ));
        }
        return $lesActeurs;
    }
    
    public function getCommentaire() {
        $lesCommentaires = array();
        $requeteCommentaires = <<<SQL
        SELECT id, idFilm
        , auteur, datePost, contenu    
        FROM Commentaire
        ORDER by datePost
SQL;
        $resultat = $this->db->prepare($requeteCommentaires);
        $resultat->execute();
        while($data = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $film = new film(array(
                                    'id'=>$data['idFilm']                                   
            ));
            $lesCommentaires[] = new commentaire(array(
                                                        'id'=>$data['id'],
                                                        'auteur'=>$data['auteur'],
                                                        'datePost'=>$data['datePost'],
                                                        'contenu'=>$data['contenu'],
                                                        'idFilm'=>$film
            ));
        }
        return $lesCommentaires;
    }
    
    
    function addComment($idFilm, $auteur, $contenu) {
        $addComment = <<<SQL
        INSERT INTO commentaire (idFilm, auteur, datePost, contenu)
        VALUES (:idFilm, :auteur, :datePost, :contenu)
SQL;
        $action = $this->db->prepare($addComment);
        $action->bindValue(':auteur', $auteur, PDO::PARAM_STR);
        $action->bindValue(':datePost', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $action->bindValue(':contenu', $contenu, PDO::PARAM_STR);
        $action->bindValue(':idFilm', $idFilm, PDO::PARAM_STR);
        
        
        
        $action->execute();
    }
}

