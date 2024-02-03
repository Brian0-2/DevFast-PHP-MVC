<?php

namespace Controllers;

use MVC\Router;
use Model\ActiveRecord;
use Model\ConsultaDevolucion;
use Model\Devolucion;
use Model\MotivoDevolucion;
use Model\Viaje;

class ChoferController extends ActiveRecord
{

    public static function index(Router $router)
    {
        session_start();
        isChofer();
        $userId = $_SESSION['id'];
        $_SESSION = sanitizarPost($_SESSION);

        $fecha = date('Y-m-d');

        $query = "SELECT fechaviaje,horallegada,horaalta,cantidadfacturas,id_usuario 
                    FROM viajes 
                    WHERE fechaviaje = '$fecha' AND id_usuario = $userId";

        $viaje = Viaje::SQL($query);

        $router->render('/choferes/index/index', [
            'titulo' => 'Panel Choferes',
            'viaje' => $viaje
        ]);
    }

    public static function crear_devolucion(Router $router)
    {
        session_start();
        isChofer();
        $alertas = [];
        $usuario = $_SESSION['id'];
        $_SESSION = sanitizarPost($_SESSION);

        $fecha = date('Y-m-d');
        $query = "SELECT * FROM viajes WHERE fechaviaje = '$fecha' AND id_usuario = $usuario ORDER BY id DESC LIMIT 1";

        $viajeAsociado = Viaje::SQL($query);

        //Validar que si haya un viaje asociado
        if (empty($viajeAsociado)) {
            header('Location: /choferes/index');
            exit;
        }

        foreach ($viajeAsociado as $viajeA) {
            $id = $viajeA;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $devolucion = new Devolucion($_POST);

            $devolucion->sincronizar($_POST);

            //Validar que se guarde al viaje al que pertenece 
            if ($devolucion->id_viaje != $viajeA->id) {
                Viaje::setAlerta('error', 'Error con la devolucion...');
            }

            $alertas = $devolucion->validarDev();

            if (empty($alertas)) {
                $devolucion->guardar();
                header('Location: /choferes/index');
                exit;
            }
        }

        $motivodev = MotivoDevolucion::all();
        Viaje::getAlertas();
        $router->render('/choferes/index/formulario', [
            'titulo' => 'Crear devolucion',
            'motivodev' => $motivodev,
            'alertas' => $alertas,
            'id_viaje' => $id
        ]);
    }

    public static function mostrarDevoluciones(Router $router)
    {
        session_start();
        isChofer();
        $fecha = date('Y-m-d');
        $chofer = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $fecha = $_POST['fecha'] ?? date('Y-m-d');
            // Verificamos si se ha enviado un formulario POST
            if (empty($fecha)) {
                $fecha = date('Y-m-d');
            }
        }
        $query = "SELECT
                    D.id AS id,
                    D.fechacreacion AS fecha,
                    D.horascreacion AS horas,
                    U.nombre AS chofer,
                    D.cantidadmaterial AS cantidadmaterial,
                    D.descripcion AS descripcion,
                    D.calero AS calero,
                    D.macario AS macario,
                    M.folio AS folio_material,
                    M.id_almacen AS almacen,
                    M.descripcion AS material,
                    MD.motivo AS motivo,
                    F.folio AS factura,
                    M.precio AS precio,
                    D.cantidadmaterial as piezas,
                    (D.cantidadmaterial * M.precio) AS total,
                    C.folio AS folio_cliente,
                    C.nombre AS cliente,
                    R.nombre AS ruta
                FROM devoluciones D
                LEFT JOIN materiales M ON D.id_material = M.id
                LEFT JOIN motivodev MD ON D.id_motivodev = MD.id
                LEFT JOIN facturas F ON D.id_factura = F.id
                LEFT JOIN clientes C ON F.id_cliente = C.id
                LEFT JOIN viajes V ON D.id_viaje = V.id
                LEFT JOIN usuarios U ON V.id_usuario = U.id
                LEFT JOIN rutas R ON V.id_ruta = R.id
                WHERE U.id = $chofer AND D.fechacreacion = '$fecha' ORDER BY D.id DESC;
            ";


        $devoluciones = ConsultaDevolucion::SQL($query);

        $router->render('choferes/devoluciones/index', [
            'titulo' => 'Mostrar Devoluciones',
            'devoluciones' => $devoluciones,
            'fecha' => $fecha
        ]);
    }
}
