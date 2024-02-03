<?php

namespace Model;

class Usuario extends ActiveRecord{

    public static $tabla = 'usuarios';
    public static $columnasDB = ['id','nombre','password','imagen','tipousuario','id_almacen'];

    public $id;
    public $nombre;
    public $password;
    public $imagen;
    public $tipousuario;
    public $id_almacen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->tipousuario = $args['tipousuario'] ?? '';
        $this->id_almacen = $args['id_almacen'] ?? null;
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this-> nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;

    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
       
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }

        if($this->tipousuario === '') {
            self::$alertas['error'][] = 'El Tipo de usuario es obligatorio';
        }
    
        return self::$alertas;
    }

    
    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}