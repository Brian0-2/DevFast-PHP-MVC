<?php

namespace Controllers;

use Model\ConsultaDevolucion;
use MVC\Router;

class AlmacenController
{
    public static function index(Router $router)
    {
        session_start();
        isAlmacen();
        $fecha = date('Y-m-d');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            $fecha = $_POST['fecha'] ?? date('Y-m-d');
            // Verificamos si se ha enviado un formulario POST
            if (empty($fecha)) {
                $fecha = date('Y-m-d');
            }
        }

        $almacenes_formateados = [];

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
        R.nombre AS ruta,
        V.id AS folio_viaje
    FROM devoluciones D
    LEFT JOIN materiales M ON D.id_material = M.id
    LEFT JOIN motivodev MD ON D.id_motivodev = MD.id
    LEFT JOIN facturas F ON D.id_factura = F.id
    LEFT JOIN clientes C ON F.id_cliente = C.id
    LEFT JOIN viajes V ON D.id_viaje = V.id
    LEFT JOIN usuarios U ON V.id_usuario = U.id
    LEFT JOIN rutas R ON V.id_ruta = R.id
    WHERE D.fechacreacion = '$fecha' ORDER BY D.id DESC;
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

        $router->render('/almacen/index/index', [
            'titulo' => 'Panel Alamacen',
            'almacenes' => $almacenes_formateados,
            'fecha' => $fecha
        ]);
    }
}
