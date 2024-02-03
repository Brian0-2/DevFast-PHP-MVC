<?php
namespace Controllers;

use Model\Almacen;

class APIAlmacenes {
   public static function index(){
    session_start();
     if(!$_SESSION){
         echo json_encode(['...']);
         return;
     }
     
     $_GET = sanitizarPost($_GET);

    $almacenes = Almacen::all();
    echo json_encode($almacenes);
   }
}
