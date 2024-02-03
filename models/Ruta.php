<?php 

namespace Model;

use Model\ActiveRecord;

class Ruta extends ActiveRecord{
    
    public static $tabla = 'rutas';
    public static $columnasDB = ['id','nombre'];

    public $id;
    public $nombre;

    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? '';
    }

    public function validarRuta(){
        if(!$this -> nombre){
            self::$alertas['error'][] = 'El nombre de la ruta es Obligatorio';
        }
        if(strlen($this->nombre) < 6){
            self::$alertas['error'][] = 'El nombre de la ruta Debe contener por lo menos 6 caracteres';
        }
        return self::$alertas;
    }

}