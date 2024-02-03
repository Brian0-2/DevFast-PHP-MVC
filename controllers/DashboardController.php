<?php

namespace Controllers;

use Model\Devolucion;
use Model\Ruta;
use MVC\Router;
use Model\Viaje;
use Model\Usuario;


class DashboardController
{

    public static function index(Router $router)
    {
        session_start();
        isAdmin();

        $alertas = [];
        $date = $_GET['fecha'] ?? date('Y-m-d'); // Definir una fecha por defecto
        $_GET = sanitizarPost($_GET);

        $viajes = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $date = $_POST['fecha'] ?? date('Y-m-d');
            // Verificamos si se ha enviado un formulario POST
            if (empty($date)) {
                $date = date('Y-m-d');
            }
            $viajes = Viaje::where2('fechaviaje', $date);
        } else {
            // Si no se ha enviado un formulario POST, obtenemos los viajes para la fecha especificada
            $viajes = Viaje::where2('fechaviaje', $date);
        }
        foreach ($viajes as $viaje) {
            $viaje->ruta = Ruta::find($viaje->id_ruta);
            $viaje->chofer = Usuario::find($viaje->id_usuario);
        }

        $router->render('admin/index/index', [
            'titulo' => 'Viajes',
            'alertas' => $alertas,
            'viajes' => $viajes,
            'viaje' => $date
        ]);
    }



    public static function crear(Router $router)
    {
        session_start();
        isAdmin();

        $fechaViaje = $_GET['fecha'];
        $_GET = sanitizarPost($_GET);

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            isAdmin();

            $viaje = new Viaje($_POST);
            $usuario = new Usuario($_POST);

            // dd($usuario);
            $usuario->sincronizar($_POST);
            $viaje->sincronizar($_POST);
            // dd($viaje);

            $alertas = $viaje->validarViaje();


            if (empty($alertas)) {
                //Obtener Ruta
                $viaje->id_ruta = $_POST['id_ruta'];
                //Obtener Usuario
                $viaje->id_usuario = $_POST['id_usuario'];

                //Si no hay clientes atendidos , quitalos del objeto.
                if (!$viaje->clientesatendidos) {
                    unset($viaje->clientesatendidos);
                }

                //Si el viaje tiene fecha agregasela ala variable $_GET
                if (!empty($viaje->fechaviaje)) {
                    $viaje->fechaviaje = $fechaViaje;
                }

                //Validar que exista tanto el usuario como la ruta 
                $usuario = Usuario::find($viaje->id_usuario);
                $ruta = Ruta::find($viaje->id_ruta);

                if (!$usuario || !$ruta) {
                    Usuario::setAlerta('error', 'Error al ingresar los datos...');
                } else {
                    //Guardar registro y dar de alta el Viaje
                    $viaje->guardar();
                    header('Location: /admin/index');
                }
            }
        }
        // Consulta para obtener los viajes que faltan por agregar en el día actual, días anteriores y siguientes.
        $fechaActual = $fechaViaje;

        $query = " SELECT * FROM rutas WHERE id NOT IN ( SELECT id_ruta FROM viajes WHERE DATE(fechaviaje) = '$fechaActual')";
        $rutas = Ruta::SQL($query);

        $query2 = " SELECT * FROM usuarios WHERE id NOT IN ( SELECT id_usuario FROM viajes WHERE DATE(fechaviaje) = '$fechaActual') AND tipousuario = 0";
        $usuarios = Ruta::SQL($query2);

        $alertas = Usuario::getAlertas();
        $router->render('admin/index/crear', [
            'titulo' => 'Dar de alta viaje',
            'alertas' => $alertas,
            'rutas' => $rutas,
            'usuarios' => $usuarios,
            'viaje' => $viaje ?? ''
        ]);
    }

    public static function editar(Router $router)
    {
        session_start();
        isAdmin();
        $alertas = [];
        //Validar ID
        $id = $_GET['id'];
        $fechaViaje = $_GET['fecha'] ?? date('Y-m-d');

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/index');
        }
        $_GET = sanitizarPost($_GET);


        $viajes = Viaje::find2($id);
        //traer nombre del viaje
        foreach ($viajes as $viaje) {
            $viaje->ruta = Ruta::find($viaje->id_ruta);
            $viaje->usuario = Usuario::find($viaje->id_usuario);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $viajesPost = new Viaje();

            $viajesPost->sincronizar($_POST);


            $alertas = $viajesPost->validarEdicion();

            if (empty($alertas)) {
                $usuario = Usuario::where('id', $viajesPost->id_usuario);

                if (!$usuario) {
                    Usuario::setAlerta('error', 'Error Con el chofer');
                } else {

                    $viajesPost->guardar();
                    $fechaActual = date('Y-m-d');
                    $fechaActual = $viajesPost->fechaviaje;
                    header('Location: /admin/index');
                }
            }
        }

        //Solo darme los usuarios que aun no se an creado en la fecha actual
        $query = "SELECT id,nombre FROM usuarios WHERE id NOT IN ( SELECT id_usuario FROM viajes WHERE DATE(fechaviaje) = '$fechaViaje') AND tipousuario = 0";
        $usuarios = Usuario::SQL($query);

        $alertas = Usuario::getAlertas();
        $router->render('/admin/index/editar', [
            'titulo' => 'Editar Viaje',
            'alertas' => $alertas,
            'viajes' => $viajes,
            'usuarios' => $usuarios
        ]);
    }

    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            if (!$_SESSION) {
                echo json_encode(['...']);
                return;
            }

            $_POST = sanitizarPost($_POST);


            $devolucionViaje = Devolucion::where('id_viaje', $_POST['id']);

            if ($devolucionViaje) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Error, nose puede borrar el viaje porque ya tiene una devolucion...'
                ];

                echo json_encode($respuesta);
                return;
            }
            $viaje = new Viaje($_POST);

            $resultado = $viaje->eliminar();
            ;
            $respuesta = [
                'resultado' => $resultado,
                'tipo' => 'success',
                'mensaje' => 'Eliminado Correctamente'
            ];
            echo json_encode($respuesta);
        }
    }
}
