<?php

namespace Classes;

use Model\ActiveRecord;
use Model\ConsultaDevolucion;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};


class Excel extends ActiveRecord
{
    public function crearExcel()
    {

        $_POST = sanitizarPost($_POST);

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
                M.precio AS precio,
                D.cantidadmaterial AS piezas,
                (D.cantidadmaterial * M.precio) AS total,
                MD.motivo AS motivo,
                M.id_almacen AS almacen,
                CASE
                    WHEN D.descripcion = '0' THEN 'Ninguna...'
                    ELSE D.descripcion
                    END AS descripcion,
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
            WHERE true";


        // //Ruta sea igual a la seleccionada
        if (!empty($_POST['viaje'])) {
            $query .= " AND R.id = " . $_POST['viaje'] . "";
        }

        //Mes sea igual al Seleccionado
        if (!empty($_POST['mes-ini']) && !empty($_POST['mes-final'])) {
            $query .= " AND D.fechacreacion BETWEEN '" . $_POST['mes-ini'] . "' AND '" . $_POST['mes-final'] . "'";
        }

        //Chofer sea igual a la seleccionada
        if (!empty($_POST['chofer'])) {
            $query .= " AND U.id = " . $_POST['chofer'] . "";
        }

        //Motivo de devolucion que sea igual a la seleccionada
        if (!empty($_POST['motivo-dev'])) {
            $query .= " AND MD.id = " . $_POST['motivo-dev'] . "";
        }

        //Almacen sea igual a la seleccionada
        if (!empty($_POST['almacen'])) {
            $query .= " AND M.id_almacen = " . $_POST['almacen'] . "";
        }

        // dd($query);
        $resultados = ConsultaDevolucion::SQL($query);
      
        // dd($resultados);
        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();


        $hojaActiva->mergeCells('A1:V1');
        // Establecer el título en la celda combinada
        $hojaActiva->setCellValue('A1', 'Devoluciones Ferrusa');

        // Establecer los estilos para el título combinado
        $tituloStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                // Color de letra blanco
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'ff5500'],
                // Color de fondo azul oscuro
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                // Centrar horizontalmente
                'vertical' => Alignment::VERTICAL_CENTER,
                // Centrar verticalmente
            ],
        ];

        $hojaActiva->getStyle('A1')->applyFromArray($tituloStyle);

        // Titulos de columnas
        $titulos = array(

            'id',
            'folio_cliente',
            'cliente',
            'factura',
            'fecha',
            'horas',
            'folio_material',
            'material',
            'cantidadmaterial',
            'descripcion',
            'precio',
            'piezas',
            'total',
            'motivo',
            'almacen',
            'calero',
            'macario',
            'taka',
            'facturo',
            'chofer',
            'ruta',
            'folio_viaje'
        );

        // Establecer los estilos para los títulos de las columnas
        foreach ($titulos as $indice => $titulo) {
            $letraColumna = chr(65 + $indice); // Convertir el índice en letra de columna (A, B, C, ...)

            $hojaActiva->getStyle($letraColumna . '2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('293241');
            $hojaActiva->getStyle($letraColumna . '2')->getFont()->getColor()->setRGB('ff5500');
            $hojaActiva->getStyle($letraColumna . '2')->getFont()->setBold(true);
            $hojaActiva->setAutoFilter($letraColumna . '2');
            $hojaActiva->setCellValue($letraColumna . '2', $titulo);
        }

        $hojaActiva->setAutoFilter('A2:' . $letraColumna . '2');
        $hojaActiva->getColumnDimension('A')->setWidth(5);
        $hojaActiva->getColumnDimension('B')->setWidth(8);
        $hojaActiva->getColumnDimension('C')->setWidth(25);
        $hojaActiva->getColumnDimension('D')->setWidth(10);
        $hojaActiva->getColumnDimension('E')->setWidth(13);
        $hojaActiva->getColumnDimension('F')->setWidth(10);
        $hojaActiva->getColumnDimension('G')->setWidth(15);
        $hojaActiva->getColumnDimension('H')->setWidth(50);
        $hojaActiva->getColumnDimension('I')->setWidth(6);
        $hojaActiva->getColumnDimension('J')->setWidth(10);
        $hojaActiva->getColumnDimension('K')->setWidth(10);
        $hojaActiva->getColumnDimension('L')->setWidth(10);
        $hojaActiva->getColumnDimension('M')->setWidth(10);
        $hojaActiva->getColumnDimension('N')->setWidth(17);
        $hojaActiva->getColumnDimension('O')->setWidth(5);
        $hojaActiva->getColumnDimension('P')->setWidth(10);
        $hojaActiva->getColumnDimension('Q')->setWidth(10);
        $hojaActiva->getColumnDimension('R')->setWidth(10);
        $hojaActiva->getColumnDimension('S')->setWidth(10);
        $hojaActiva->getColumnDimension('T')->setWidth(10);
        $hojaActiva->getColumnDimension('U')->setWidth(28);
        $hojaActiva->getColumnDimension('V')->setWidth(10);
        //Comenzar en la fila 3 de hoja de excel

        $fila = 3;


        foreach ($resultados as $resultado) {
            $hojaActiva->setCellValue('A' . $fila, $resultado->id); // id
            $hojaActiva->setCellValue('B' . $fila, $resultado->folio_cliente); // folio_cliente
            $hojaActiva->setCellValue('C' . $fila, $resultado->cliente); // cliente
            $hojaActiva->setCellValue('D' . $fila, $resultado->factura); // factura
            $hojaActiva->setCellValue('E' . $fila, $resultado->fecha); // fecha
            $hojaActiva->setCellValue('F' . $fila, $resultado->horas); // horas
            $hojaActiva->setCellValue('G' . $fila, $resultado->folio_material); // folio_material
            $hojaActiva->setCellValue('H' . $fila, $resultado->material); // material
            $hojaActiva->setCellValue('I' . $fila, $resultado->cantidadmaterial); // cantidadmaterial
            $hojaActiva->setCellValue('J' . $fila, $resultado->descripcion); // descripcion
            $hojaActiva->setCellValue('K' . $fila, $resultado->precio); // precio
            $hojaActiva->setCellValue('L' . $fila, $resultado->piezas); // piezas
            $hojaActiva->setCellValue('M' . $fila, $resultado->total); // total
            $hojaActiva->setCellValue('N' . $fila, $resultado->motivo); // motivo
            $hojaActiva->setCellValue('O' . $fila, $resultado->almacen); // almacen
            $hojaActiva->setCellValue('P' . $fila, $resultado->calero); // calero
            $hojaActiva->setCellValue('Q' . $fila, $resultado->macario); // macario
            $hojaActiva->setCellValue('R' . $fila, $resultado->taka); // taka
            $hojaActiva->setCellValue('S' . $fila, $resultado->facturo); // facturo
            $hojaActiva->setCellValue('T' . $fila, $resultado->chofer); // chofer
            $hojaActiva->setCellValue('U' . $fila, $resultado->ruta); // ruta
            $hojaActiva->setCellValue('V' . $fila, $resultado->folio_viaje); // folio_viaje

            $fila++;
        }

        //Headers para poder descargar archivos Xlsx desde el navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Devoluciones-' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');

        //Detener la ejecucion
        exit;
    }
}
