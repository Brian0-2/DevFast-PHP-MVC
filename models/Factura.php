<?php

namespace Model;

class Factura extends ActiveRecord{
    public static $tabla = 'facturas';
    public static $columnasDB = ['id','folio','id_cliente','id_material','id_empleado'];

    public $id;
    public $folio;
    public $id_cliente;
    public $id_material;
    public $id_empleado;
}