<?php

namespace Controllers;

use MVC\Router;

class JefesController{
    public static function index(Router $router){
        session_start();
        isJefe();

        
        $router -> render('/jefes/index/index',[
            'titulo' => 'Jefes Controller'
        ]);
    }
}