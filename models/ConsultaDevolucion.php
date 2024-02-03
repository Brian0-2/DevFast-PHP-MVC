<?php
namespace Model;

class ConsultaDevolucion extends ActiveRecord{ 
     public static $tabla = 'devoluciones';
     public static $columnasDB =
 ['id','folio_cliente','cliente','factura','fecha','horas','folio_material','material','cantidadmaterial','descripcion','precio','piezas','total','motivo','almacen','calero','macario','taka','facturo','chofer','folio_ruta','ruta','folio_viaje','estado'];

 public $id;
 public $folio_cliente;
 public $cliente;
 public $factura;
 public $fecha;
 public $horas;
 public $folio_material;
 public $material;
 public $cantidadmaterial;
 public $descripcion;
 public $precio;
 public $piezas;
 public $total;
 public $motivo;
 public $almacen;
 public $calero;
 public $macario;
 public $taka;
 public $facturo;
 public $chofer;
 public $folio_ruta;
 public $ruta;
 public $folio_viaje;
 public $estado;
 

}