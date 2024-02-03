<?php

namespace Controllers;

use Model\Devolucion;
use Model\MotivoDevolucion;

class APIPronosticos
{
    public static function index()
    {
        session_start();
        
        if(!$_SESSION){
            echo json_encode(['...']);
            return;
        }

        $yearSelected = $_GET['year'] ?? date('Y');;
        $monthSelected = $_GET['month'] ?? date('m');;

        $_GET = sanitizarPost($_GET);

        if (empty($yearSelected) || empty($monthSelected) || !is_numeric($yearSelected) || !is_numeric($monthSelected)) {
            $yearSelected = date('Y');
            $monthSelected = date('m');
        }
        //Traeme todos los motivos de devolucion
        $query = "SELECT id, motivo FROM motivodev";
        $devoluciones = MotivoDevolucion::SQL($query);

        foreach ($devoluciones as $devolucion) {
            // Modifica el arreglo de condiciones
            // Condiciones de la busqueda
            $conditions = [
                'id_motivodev' => $devolucion->id,
                'YEAR(fechacreacion)' => $yearSelected,
                'MONTH(fechacreacion)' => $monthSelected
            ];

            $devolucion->total = Devolucion::totalArray($conditions);
        }

        echo json_encode($devoluciones);
        return;
    }
}
