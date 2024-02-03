<?php

namespace Model;

class MotivoDevolucion extends ActiveRecord{
    public static $tabla = 'motivodev';
    public static $columnasDB = ['id','motivo'];

    public $id;
    public $motivo;

    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null;
        $this -> motivo = $args['motivo'] ?? '';
    }

    public function validar(){

        if(!$this -> motivo){
            self::$alertas['error'][] = 'El Motivo de la Devolucion es Obligatorio';
        }
        if(strlen($this -> motivo) < 9){
            self::$alertas['error'][] = 'El Motivo Debe Contener por Lo Menos 9 caracteres';
        }

        return self::$alertas;
    }
}