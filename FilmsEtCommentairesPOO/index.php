<?php
  require_once('InstancierTwig.php');
  require_once('includes/dbconnect.php');
  $connexion = connect();

  function chargerClasse($classe) {
    require $classe . '.class.php';
  }
  spl_autoload_register('chargerClasse');

  $manager = new BlogManager($connexion);
  $films = $manager->getListFilm();

  echo $twig->render('index.html.twig', array(
    'films' => $films
  ));