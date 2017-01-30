<?php
  require_once('InstancierTwig.php');
  require_once('includes/dbconnect.php');
  $connexion = connect();

  require_once('includes/get_filmAll.php');
  $film = get_filmAll($connexion);
  require_once('includes/get_acteurAll.php');
  $acteurs = get_acteurAll($connexion);

  echo $twig->render('index.html.twig', array(
        'film' => $film
        , 'acteur' => $acteurs
  ));
