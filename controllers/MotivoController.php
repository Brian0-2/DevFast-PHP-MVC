<?php

namespace Controllers;

use MVC\Router;
use Model\Devolucion;
use Classes\Paginacion;
use Model\MotivoDevolucion;

class MotivoController
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
            header('Location: /admin/motivos?page=1');
        }

        $registros_por_pagina = 10;
        $total = MotivoDevolucion::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/motivos?page=1');
        }

        $motivo_dev =  MotivoDevolucion::paginar('*', '', $registros_por_pagina, $paginacion->offset());

        $router->render('/admin/motivos/index', [
            'titulo' => 'Motivo de devolucion',
            'alertas' => $alertas,
            'motivos' => $motivo_dev,
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

            $motivo = new MotivoDevolucion();

            $motivo->sincronizar($_POST);

            $alertas =  $motivo->validar();

            if (empty($alertas)) {

                $respuesta =  $motivo->guardar();

                if ($respuesta) {
                    header('Location: /admin/motivos');
                    exit;
                }
            }
        }

        $router->render('/admin/motivos/crear', [
            'titulo' => 'Crear Nuevo Motivo de devolucion',
            'alertas' => $alertas
        ]);
    }

    public static function editar(Router $router)
    {
        session_start();
        isAdmin();

        $alertas = [];

        //Validar ID
        $id = $_GET['id'];
        $_GET = sanitizarPost($_GET);

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/index');
        }

        $motivo = MotivoDevolucion::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $motivo->sincronizar($_POST);

            $alertas = $motivo->validar();

            if (empty($alertas)) {

                $existe = MotivoDevolucion::find($motivo->id);

                if ($existe === null) {
                    $alertas = MotivoDevolucion::setAlerta('error', 'Error Motivo no existente...');
                } else {

                    $motivo->guardar();
                    header('Location: /admin/motivos');
                    exit;
                }
            }
        }

        $alertas =   MotivoDevolucion::getAlertas();

        $router->render('/admin/motivos/editar', [
            'titulo' => 'Editar motivo de devolucion',
            'alertas' => $alertas,
            'motivo' => $motivo
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

            $motivoEncontrado = Devolucion::where('id_motivodev', $_POST['id']);

            if ($motivoEncontrado) {
                $resultado = [
                    'tipo' => 'error',
                    'mensaje' => 'El motivo no se puede borrar porque pertenece ya a una devolucion...'
                ];
                echo json_encode($resultado);
                return;
            }

            $motivoEliminado = new MotivoDevolucion($_POST);

            $resultado = $motivoEliminado->eliminar();

            $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Eliminado Correctamente',
                'tipo' => 'success'
            ];

            echo json_encode($resultado);
        }
    }
}
