<?php

namespace Model;

class DetalleFactura extends ActiveRecord{
    public static $tabla = 'facturas';
    public static $columnasDB = ['id','factura','id_cliente','folio_cliente','nombre_cliente','id_facturista','facturo'];

    public $id;
    public $factura;
    public $id_cliente;
    public $folio_cliente;
    public $nombre_cliente;
    public $id_facturista;
    public $facturo;
}