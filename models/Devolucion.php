<?php

namespace Model;

class Devolucion extends ActiveRecord{
    public static $tabla = 'devoluciones';
    public static $columnasDB = ['id','fechacreacion','horascreacion','cantidadmaterial','calero','macario','taka','descripcion','id_material','id_factura','id_viaje','id_motivodev','estado'];

    public $id;
    public $fechacreacion;
    public $horascreacion;
    public $cantidadmaterial;
    public $calero;
    public $macario;
    public $taka;
    public $descripcion;
    public $id_material;
    public $id_factura;
    public $id_viaje;
    public $id_motivodev;
    public $estado;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->fechacreacion = $args['fechacreacion'] ?? date('Y-m-d');
            $this->horascreacion = $args['horascreacion'] ?? date('H:i:s');
            $this->cantidadmaterial = $args['cantidadmaterial'] ?? '';
            $this->calero = $args['calero'] ?? 0;
            $this->macario = $args['macario'] ?? 0;
            $this->taka = $args['taka'] ?? 0;
            $this->descripcion = $args['descripcion'] ?? '';
            $this->id_material = $args['id_material'] ?? '';
            $this->id_factura = $args['id_factura'] ?? '';
            $this->id_viaje = $args['id_viaje'] ?? '';
            $this->id_motivodev = $args['id_motivodev'] ?? '';
            $this->estado = $args['estado'] ?? 0;
        }
        
        public function validarDev()
        {
            if(!$this -> id_factura){
                self::$alertas['error'][] = 'La Factura es Obligatoria...';
            }
            if(!$this -> id_viaje){
                self::$alertas['error'][] = 'El Viaje es Obligatorio...';
            }
            if(!$this -> id_motivodev){
                self::$alertas['error'][] = 'El Motivo de devolucion es Obligatorio...';
            }
            if(!$this -> cantidadmaterial){
                self::$alertas['error'][] = 'La Cantidad de Facturas es Obligatorio';
            }
            if( !preg_match("/^[1-9][0-9]*$/",$this->cantidadmaterial)) {
                self::$alertas['error'][] = 'El formato de las piesas no es valido...';
            }

            return self::$alertas;
        }
}