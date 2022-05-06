<?php

namespace App\Core;

use App\Controllers\MainController;
use App\Libraries\Helper;
use App\Libraries\SuperGlobal;

/**
 * Routeur principal
 */
class Main
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
    }

    public function start()
    {
        $global = new SuperGlobal();
        // On démarre la session
        session_start();

        // On retire le "trailing slash" éventuel de l'URL
        // On récupère l'URL
        $uri = $global->get_SERVER('REQUEST_URI');

        // On vérifie que uri n'est pas vide et se termine par un /
        if (!empty($uri) && $uri[-1] === '/' && $uri[-1] != '/') {
            // On enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanente
            http_response_code(301);

            // On redirige vers l'URL sans /
            $this->helper->redirect($uri);
        }

        // On gère les paramètres d'URL
        // p= contrôleur/methode/paramètres
        // On sépare les paramètres dans un tableau
        $params = [];
        if ($global->get_GET("p") !== null)
            $params = explode('/', $global->get_GET("p"));

        if ($params[0] != '') {
            // On a au moins 1 paramètre
            // On récupère le nom du contrôleur à instancier
            // On met une majuscule en 1ère lettre, on ajoute le namespace complet avant et on ajoute "Controller" après
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // On instancie le contrôleur
            $controller = new $controller();

            // On récupère le 2ème paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                // Si il reste des paramètres on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo json_encode("The page you are looking for does not exist");
            }

        } else {
            // On n'a pas de paramètres
            // On instancie le contrôleur par défaut
            $controller = new MainController;

            // On appelle la méthode index
            $controller->index();
        }
    }
}
