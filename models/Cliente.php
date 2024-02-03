<?php 

namespace Model;

class Cliente extends ActiveRecord{
    public static $tabla = 'clientes';
    public static $columnasDB = ['id','folio','nombre'];

    public $id;
    public $folio;
    public $nombre;
    
}