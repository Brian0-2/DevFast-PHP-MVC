<?php

namespace Controllers;

use Model\DetalleFactura;
use Model\Material;

class APIFacturas
{
    public static function index()
    {
        session_start();
        $folio = $_GET['folio'] ?? '';
        $folio = filter_var($folio, FILTER_VALIDATE_INT);
        
        if (!$folio || !$_SESSION) {
            echo json_encode([]);
            return;
        }

        $_GET = sanitizarPost($_GET);


        $query =  "SELECT
                f.id as id,
                f.folio as factura,
                clientes.id AS id_cliente,
                clientes.folio AS folio_cliente,
                clientes.nombre AS nombre_cliente,
                empleados.id AS id_facturista,
                empleados.nombre AS facturo
            FROM facturas AS F
            LEFT JOIN clientes ON clientes.id = F.id_cliente
            LEFT JOIN empleados ON empleados.id = F.id_empleado
            WHERE F.folio = '{$folio}'
        ";

        $factura = DetalleFactura::SQL($query);

        if ($factura) {
            echo json_encode($factura);
        } else {
            echo json_encode([]);
        }
    }

    public static function mostrarMaterial()
    {
        session_start();
        $folioFactura = $_GET['id'] ?? '';

        if (!$_SESSION) {
            echo json_encode([]);
            return;
        }

        $_GET = sanitizarPost($_GET);

        $query = "SELECT M.* 
        FROM materiales M
        JOIN facturas F ON M.id_factura = F.id
        WHERE F.folio = '{$folioFactura}'";

        $materiales = Material::SQL($query);

        echo json_encode($materiales);
    }
}
