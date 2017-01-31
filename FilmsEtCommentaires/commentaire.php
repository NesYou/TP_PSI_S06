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

  echo $twig->render('commentaire.html.twig', array(
    'GET' => $_GET,
    'commentaires' => $commentaires,
    'films' => $films,
    'acteurs' => $acteurs
  ));
