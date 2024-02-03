<?php

namespace Controllers;

use Model\Devolucion;
use Model\Ruta;
use MVC\Router;
use Classes\Paginacion;
use Model\ConsultaDevolucion;

class DevolucionController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        $alertas = [];

        $rutas = Ruta::all();
        $pagina_actual = $_GET['page'];

        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        //Garantizar que estamos en la pagina actual correcta
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/devoluciones?page=1');
        }

        $registros_por_pagina = 12;
        $total = Ruta::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/devoluciones?page=1');
        }

        $rutas = Ruta::paginar('*', '', $registros_por_pagina, $paginacion->offset());

        $router->render('/admin/devoluciones/index', [
            'titulo' => 'Buscar Viajes',
            'alertas' => $alertas,
            'rutas' => $rutas,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function mostrar(Router $router)
    {
        session_start();
        isAdmin();
        $alertas = [];
        $date = $_GET['fecha'] ?? date('Y-m-d'); // Definir una fecha por defecto

        $idRuta = $_GET['id'];
        $idRuta = filter_var($idRuta, FILTER_VALIDATE_INT);
        if (!$idRuta) {
            header('Location: /admin/devoluciones');
        }

        $_GET = sanitizarPost($_GET);
        $ruta = Ruta::find($idRuta);

        //Validar que exista la ruta
        if (!$ruta) {
            header('Location: /admin/devoluciones/mostrar');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $date = $_POST['fecha'] ?? date('Y-m-d');
            // Verificamos si se ha enviado un formulario POST
            if (empty($date)) {
                $date = date('Y-m-d');
            }
        }

        $almacenes_formateados = [];

        $query = "SELECT
         D.id AS id,
         C.folio AS folio_cliente,
         C.nombre AS cliente,
         F.folio AS factura,
         D.fechacreacion AS fecha,
         D.horascreacion AS horas,
         M.folio AS folio_material,
         M.descripcion AS material,
         D.cantidadmaterial AS cantidadmaterial,
         D.descripcion AS descripcion,
         M.precio AS precio,
         D.cantidadmaterial AS piezas,
         (D.cantidadmaterial * M.precio) AS total,
         MD.motivo AS motivo,
         M.id_almacen AS almacen,
         D.estado AS estado,
         CASE
             WHEN D.calero = 0 THEN 'Pendiente'
             WHEN D.calero = 1 THEN 'Revisado'
             ELSE 'Desconocido'
         END AS calero,
         CASE
             WHEN D.macario = 0 THEN 'Pendiente'
             WHEN D.macario = 1 THEN 'Revisado'
             ELSE 'Desconocido'
         END AS macario,
         CASE
             WHEN D.taka = 0 THEN 'Pendiente'
             WHEN D.taka = 1 THEN 'Revisado'
             ELSE 'Desconocido'
         END AS taka,
         E.nombre AS facturo,
         U.nombre AS chofer,
         R.id AS folio_ruta,
         R.nombre AS ruta,
         V.id AS folio_viaje
     FROM devoluciones D
     LEFT JOIN materiales M ON D.id_material = M.id
     LEFT JOIN motivodev MD ON D.id_motivodev = MD.id
     LEFT JOIN facturas F ON D.id_factura = F.id
     LEFT JOIN empleados E ON F.id_empleado = E.id
     LEFT JOIN clientes C ON F.id_cliente = C.id
     LEFT JOIN viajes V ON D.id_viaje = V.id
     LEFT JOIN usuarios U ON V.id_usuario = U.id
     LEFT JOIN rutas R ON V.id_ruta = R.id
     WHERE R.id = $idRuta AND D.fechacreacion = '$date'
     ";

        $almacenes = ConsultaDevolucion::SQL($query);

        foreach ($almacenes as $almacen) {
            if ($almacen->almacen === '1') {
                $almacenes_formateados['almacen_1'][] = $almacen;
            }
            if ($almacen->almacen === '2') {
                $almacenes_formateados['almacen_2'][] = $almacen;
            }
            if ($almacen->almacen === '3') {
                $almacenes_formateados['almacen_3'][] = $almacen;
            }
            if ($almacen->almacen === '4') {
                $almacenes_formateados['almacen_4'][] = $almacen;
            }
        }

        $router->render('/admin/devoluciones/mostrar', [
            'titulo' => "Devoluciones de " . $ruta->nombre,
            'alertas' => $alertas,
            'almacenes' => $almacenes_formateados,
            'fecha' => $date,
            'ruta' => $ruta
        ]);
    }

    public static function editar(Router $router)
    {
        session_start();
        isAdmin();

        $idRuta = $_GET['id'];
        $idRuta = filter_var($idRuta, FILTER_VALIDATE_INT);
        if (!$idRuta) {
            header('Location: /admin/devoluciones');
        }

        $_GET = sanitizarPost($_GET);
        $ruta = Ruta::find($idRuta);

        //Validar que exista la ruta
        if (!$ruta) {
            header('Location: /admin/devoluciones/mostrar');
        }


        $router->render('/admin/devoluciones/editar', [
            'titulo' => 'Editar Devolucion',
            'ruta' => $ruta
        ]);
    }

    public static function obtenerDev()
    {
        session_start();

        if (!$_SESSION) {
            echo json_encode(['...']);
            return;
        }

        $_GET = sanitizarPost($_GET);

        $devId = $_GET['id'];

        $query = "SELECT
        D.id AS id,
        C.folio AS folio_cliente,
        C.nombre AS cliente,
        F.folio AS factura,
        D.fechacreacion AS fecha,
        D.horascreacion AS horas,
        M.folio AS folio_material,
        M.descripcion AS material,
        D.cantidadmaterial AS cantidadmaterial,
        D.descripcion AS descripcion,
        M.precio AS precio,
        D.cantidadmaterial AS piezas,
        (D.cantidadmaterial * M.precio) AS total,
        MD.motivo AS motivo,
        M.id_almacen AS almacen,
        D.estado AS estado,
        CASE
            WHEN D.calero = 0 THEN 'Pendiente'
            WHEN D.calero = 1 THEN 'Revisado'
            ELSE 'Desconocido'
        END AS calero,
        CASE
            WHEN D.macario = 0 THEN 'Pendiente'
            WHEN D.macario = 1 THEN 'Revisado'
            ELSE 'Desconocido'
        END AS macario,
        CASE
            WHEN D.taka = 0 THEN 'Pendiente'
            WHEN D.taka = 1 THEN 'Revisado'
            ELSE 'Desconocido'
        END AS taka,
        E.nombre AS facturo,
        U.nombre AS chofer,
        R.id AS folio_ruta,
        R.nombre AS ruta,
        V.id AS folio_viaje
    FROM devoluciones D
    LEFT JOIN materiales M ON D.id_material = M.id
    LEFT JOIN motivodev MD ON D.id_motivodev = MD.id
    LEFT JOIN facturas F ON D.id_factura = F.id
    LEFT JOIN empleados E ON F.id_empleado = E.id
    LEFT JOIN clientes C ON F.id_cliente = C.id
    LEFT JOIN viajes V ON D.id_viaje = V.id
    LEFT JOIN usuarios U ON V.id_usuario = U.id
    LEFT JOIN rutas R ON V.id_ruta = R.id
    WHERE D.id = $devId
    ";


        $resultado = ConsultaDevolucion::SQL($query);

        echo json_encode($resultado);
    }

    public static function cancelarDev()
    {
        session_start();

        if (!$_SESSION) {
            echo json_encode(['...']);
            return;
        }

        $_POST = sanitizarPost($_POST);

        $dev_id = $_POST['id'];

        $cancelacion = Devolucion::find($dev_id);


        if (!$cancelacion) {
            $resultado = [
                'mensaje' => 'Hubo un error',
                'tipo' => 'error'
            ];

            echo json_encode($resultado);
            return;
        }


        $cancelacion->estado = 1;
        $resultado = $cancelacion->guardar();

        $resultado = [
            'resultado' => $resultado,
            'mensaje' => 'Cancelado correctamente...',
            'tipo' => 'success'
        ];

        echo json_encode($resultado);
    }
}
