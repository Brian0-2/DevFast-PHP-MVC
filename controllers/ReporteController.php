<?php

namespace Controllers;

use Classes\Excel;
use Model\Almacen;
use Model\MotivoDevolucion;
use Model\Ruta;
use Model\Usuario;
use MVC\Router;

class ReporteController
{

    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $excel = new Excel($_POST);
            $excel->crearExcel();
        }

        $rutas = Ruta::all();

        $query = "SELECT id,nombre FROM usuarios WHERE tipousuario = 0";
        $choferes = Usuario::SQL($query);

        $motivos = MotivoDevolucion::all();

        $queryAlmacen = "SELECT id,nombre FROM almacenes WHERE id != 5";
        $almacenes = Almacen::SQL($queryAlmacen);

        $router->render('admin/reportes/index', [
            'titulo' => 'Crear reportes',
            'rutas' => $rutas,
            'choferes' => $choferes,
            'motivos' => $motivos,
            'almacenes' => $almacenes
        ]);
    }
}