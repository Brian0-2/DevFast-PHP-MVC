<?php 
use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

//Horas de Mexico
date_default_timezone_set("America/Mexico_City");

// Añadir Dotenv, uso de variables $_ENV
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Conectarnos a la base de datos
require 'funciones.php';
require 'database.php';

ActiveRecord::setDB($db);