<?php
  require_once('InstancierTwig.php');
  require_once('includes/dbconnect.php');
  $connexion = connect();

  echo $twig->render('commentaire.html.twig', array(

  ));
