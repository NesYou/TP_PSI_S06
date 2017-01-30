<?php
    include_once('twig/lib/Twig/Autoloader.php');
    Twig_Autoloader::register();

    $loader = new Twig_Loader_Filesystem('templates'); // Dossier contenant les templates
    $twig = new Twig_Environment($loader, array(
      'cache' => false
    ));
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
    // implement whatever logic you need to determine the asset path

    return sprintf('../assets/%s', ltrim($asset, '/'));
}));
