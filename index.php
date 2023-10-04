<?php

// L'IDE limite la taille des fichiers à télécharger à 2Mo, et ce n'était pas possible de le changer
// La taille des fichiers de sauvegarde font en moyenne 6Mo donc l'upload ne fonctionne pas sur l'IDE
// J'ai du faire sur mon serveur local mais le reste est fonctionnel

require 'services/autoload.php';

session_start();
//var_dump($_SESSION['user_id']);
$router = new Router();

if(isset($_GET['path']))
{
    $router->checkRoute($_GET['path']);
}
else
{
    $router->checkRoute("");
}

?>