<?php

namespace Controllers;

use Model\Ruta;
use MVC\Router;
use Classes\Paginacion;
use Model\Viaje;

class RutaController
{

    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        $alertas = [];
        
        $pagina_actual = $_GET['page'];
        $_GET = sanitizarPost($_GET);

        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        //Garantizar que estamos en la pagina actual correcta
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/rutas?page=1');
        }

        $registros_por_pagina = 10;
        $total = Ruta::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/rutas?page=1');
        }

        $rutas =  Ruta::paginar('*','',$registros_por_pagina, $paginacion->offset());


        $router->render('/admin/rutas/index', [
            'titulo' => 'Rutas',
            'rutas' => $rutas,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAdmin();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $ruta = new Ruta($_POST);
            // Obtener el valor del campo 'nombre' del formulario POST
            $nombre = $_POST['nombre'];

            $ruta->nombre = $nombre;

            $alertas = $ruta->validarRuta();

            if (empty($alertas)) {

                $existe = Ruta::where('nombre', $ruta->nombre);
                if ($existe) {
                    $alertas = Ruta::setAlerta('error', 'Ya existe la Ruta...');
                } elseif (!$existe) {
                    $ruta->guardar();
                    header('Location: /admin/rutas');
                }
            }
        }


        $alertas = Ruta::getAlertas();
        $router->render('/admin/rutas/crear', [
            'titulo' => 'Crear Ruta',
            'alertas' => $alertas
        ]);
    }


    public static function editar(Router $router)
    {
        session_start();
        isAdmin();

        //Validar ID
        $id = $_GET['id'];

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/index');
        }
       $_GET = sanitizarPost($_GET);

        $alertas = [];
        $ruta = Ruta::find($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $ruta = new Ruta();
            $ruta->id = $_POST['id'];
            $ruta->nombre = $_POST['nombre'];

            $ruta->sincronizar($_POST);

            $alertas = $ruta->validarRuta();

            if (empty($alertas)) {
                $existe = Ruta::where('nombre', $ruta->nombre);

                if ($existe) {
                    $alertas = Ruta::setAlerta('error', 'Ya existe la Ruta...');
                } elseif (!$existe) {

                    $ruta->guardar();
                    header('Location: /admin/rutas');
                }
            }
        }
        
        $alertas = Ruta::getAlertas();
        $router->render('/admin/rutas/editar', [
            'titulo' => 'Editar Ruta',
            'alertas' => $alertas,
            'ruta' => $ruta
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            if(!$_SESSION){
                echo json_encode(['...']);
                return;
            }
            $_POST = sanitizarPost($_POST);

            $viaje = Viaje::where('id_ruta',$_POST['id']);

            if($viaje){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'No se puede borrar la ruta, ya pertenece a un viaje'
                   ];
                   echo json_encode($respuesta);
                   return;
            }

            $ruta = new Ruta($_POST);

            $resultado = $ruta ->eliminar();
            $respuesta = [
                'resultado' => $resultado,
                'tipo' => 'success',
                'mensaje' => 'Ruta borrada correctamente'
               ];

               echo json_encode($respuesta);

        }
    }
}
