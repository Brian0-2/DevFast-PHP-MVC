<?php

namespace Model;

class Almacen extends ActiveRecord{
    public static $tabla = 'almacenes';
    public static $columnasDB = ['id','nombre'];

    public $id;
    public $nombre;
}