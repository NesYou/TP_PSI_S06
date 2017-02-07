<?php
  require_once('InstancierTwig.php');
  require_once('includes/dbconnect.php');
  $connexion = connect();
  
 function chargerClasse($classe) {
    require_once dirname(__FILE__) . '/includes/' . $classe . '.class.php';
  }
  spl_autoload_register('chargerClasse');

  
  $manager = new BlogManager($connexion);
  $films = $manager->getListFilm();
  $acteurs = $manager->getActeur();
  $commentaires = $manager->getCommentaire();

  if(!empty($_POST['auteur']) or !empty($_POST['contenu'])){
    $manager->addComment($_GET['idFilm'], $_POST['auteur'], $_POST['message']);
    header('Location: commentaire.php?idFilm='.$_GET['idFilm']);
    exit();
  }
 /* else {
   echo '<script language=javascript">
            alert("Merci de remplir tous les champs du formulaire.");
         </script>';
  }
*/

  echo $twig->render('commentaire.html.twig', array(
    'GET' => $_GET,
    'POST' => $_POST,
    'commentaires' => $commentaires,
    'films' => $films,
    'acteurs' => $acteurs,
  ));
