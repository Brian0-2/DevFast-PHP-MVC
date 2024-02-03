<?php 

namespace Model;

class Material extends ActiveRecord{
    public static $tabla = 'materiales';
    public static $columnasDB = ['id','folio','descripcion','precio','id_almacen','id_factura'];

    public $id;
    public $folio;
    public $descripcion;
    public $precio;
    public $id_almacen;
    public $id_factura;

}