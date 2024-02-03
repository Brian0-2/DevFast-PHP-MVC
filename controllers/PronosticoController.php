<?php

namespace Controllers;

use MVC\Router;

class PronosticoController{

    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        $_GET = sanitizarPost($_GET);

        $router->render('admin/pronosticos/index', [
            'titulo' => 'Pronosticos'
        ]);
    }
}