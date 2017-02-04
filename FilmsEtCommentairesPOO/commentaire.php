<?php
  require_once('InstancierTwig.php');
  require_once('includes/dbconnect.php');
  $connexion = connect();

  require_once('includes/get_commentaire.php');
  $commentaires = get_commentaire($connexion);
  require_once('includes/get_filmAll.php');
  $films = get_filmAll($connexion);
  require_once('includes/get_acteurAll.php');
  $acteurs = get_acteurAll($connexion);

  require_once('includes/add_comment.php');
  if(!empty($_POST['auteur']) or !empty($_POST['contenu'])){
    $add_com = add_comment($connexion, $_GET['idFilm'], $_POST['auteur'], $_POST['message']);
  }
  else {
    $add_com = "Echec!!";
  }


  echo $twig->render('commentaire.html.twig', array(
    'GET' => $_GET,
    'POST' => $_POST,
    'commentaires' => $commentaires,
    'films' => $films,
    'acteurs' => $acteurs,
    'add_com' => $add_com
  ));
