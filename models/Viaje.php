<?php

namespace Model;

class Viaje extends ActiveRecord{
    public static $tabla = 'viajes';
    public static $columnasDB = ['id','fechaviaje','horallegada','horaalta','cantidadfacturas','clientesatendidos','id_usuario','id_ruta'];

    public $id;
    public $fechaviaje;
    public $horallegada;
    public $horaalta;

    public $cantidadfacturas;

    public $clientesatendidos;
    public $id_usuario;
    public $id_ruta;
   
    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null;
        $this -> fechaviaje = $args['fechaviaje'] ?? date('Y-m-d');
        $this -> horallegada = $args['horallegada'] ?? '';
        $this -> horaalta = $args['horaalta'] ?? date('H:i:s');
        $this -> cantidadfacturas = $args['cantidadfacturas'] ?? 0;
        $this -> clientesatendidos = $args['clientesatendidos'] ?? 0;
        $this -> id_ruta = $args['id_ruta'] ?? '';
        $this -> id_usuario = $args['id_usuario'] ?? '';
    }

    public function validarViaje(){
        if(!$this->id_ruta) {
            self::$alertas['error'][] = 'La Ruta es obligatoria';
        }

        if(!$this->id_usuario) {
            self::$alertas['error'][] = 'El Chofer es obligatoria';
        }
      

        if(!$this->cantidadfacturas) {
            self::$alertas['error'][] = 'La cantidad de facturas es obligatoria';
        }else{
            if(!is_numeric($this->cantidadfacturas)) {
                self::$alertas['error'][] = 'Las facturas solo debe contener caracteres numericos';
            }
    
            if( !preg_match("/^[1-9][0-9]*$/",$this->cantidadfacturas)) {
                self::$alertas['error'][] = 'El formato de las facturas no es valido...';
            }
        }

        // if(!$this->clientesatendidos) {
        //     self::$alertas['error'][] = 'La cantidad de clientes es obligatoria';
        // }else{
            // if(!is_numeric($this->clientesatendidos)) {
            //     self::$alertas['error'][] = 'Los clientes solo deben contener caracteres numericos';
            // }
    
            // if( !preg_match("/^[1-9][0-9]*$/",$this->clientesatendidos)) {
            //     self::$alertas['error'][] = 'El formato de los clientes no es valido...';
            // }
        // }

       

        return self::$alertas;
    }

    
    public function validarEdicion(){
        if(!$this->id_ruta) {
            self::$alertas['error'][] = 'La Ruta es obligatoria';
        }

        if(!$this->cantidadfacturas) {
            self::$alertas['error'][] = 'La cantidad de facturas es obligatoria';
        }else{
            if(!is_numeric($this->cantidadfacturas)) {
                self::$alertas['error'][] = 'Las facturas solo debe contener caracteres numericos';
            }
    
            if( !preg_match("/^[1-9][0-9]*$/",$this->cantidadfacturas)) {
                self::$alertas['error'][] = 'El formato de las facturas no es valido...';
            }
        }

        // if(!$this->clientesatendidos) {
        //     self::$alertas['error'][] = 'La cantidad de clientes es obligatoria';
        // }else{
            if(!is_numeric($this->clientesatendidos)) {
                self::$alertas['error'][] = 'Los clientes solo deben contener caracteres numericos';
            }
    
            if( !preg_match("/^[1-9][0-9]*$/",$this->clientesatendidos)) {
                self::$alertas['error'][] = 'El formato de los clientes no es valido...';
            }
        // }
        

        return self::$alertas;
    }
    
   public function mensajeAlerta (){
            self::$alertas['error'][] = 'Error con el chofer';

    return self::$alertas;
   }

    
}