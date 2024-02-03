<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AlmacenController;
use Controllers\APIAlmacenes;
use MVC\Router;

use Controllers\APIFacturas;
use Controllers\APIPronosticos;
use Controllers\AuthController;
use Controllers\RutaController;
use Controllers\JefesController;
use Controllers\ChoferController;
use Controllers\MotivoController;
use Controllers\ReporteController;
use Controllers\UsuarioController;
use Controllers\DashboardController;
use Controllers\DevolucionController;
use Controllers\PronosticoController;

$router = new Router();


//INDEX Ruta / metodo  
$router->get('/',[AuthController::class,'index']);
$router->post('/',[AuthController::class,'login']);
$router->get('/logout',[AuthController::class,'logout']);


//Zona Administracion
$router->get('/admin/index',[DashboardController::class,'index']);
$router->post('/admin/index',[DashboardController::class,'index']);
$router->get('/admin/index/crear',[DashboardController::class,'crear']);
$router->post('/admin/index/crear',[DashboardController::class,'crear']);
$router->get('/admin/index/editar',[DashboardController::class,'editar']);
$router->post('/admin/index/editar',[DashboardController::class,'editar']);
$router->post('/admin/index/eliminar',[DashboardController::class,'eliminar']);

//Pronosticos
$router->get('/admin/pronosticos',[PronosticoController::class,'index']);


//Reportes
$router->get('/admin/reportes',[ReporteController::class,'index']);
$router->post('/admin/reportes',[ReporteController::class,'index']);

//Rutas
$router->get('/admin/rutas',[RutaController::class,'index']);
$router->post('/admin/rutas',[RutaController::class,'index']);
$router->get('/admin/rutas/crear',[RutaController::class,'crear']);
$router->post('/admin/rutas/crear',[RutaController::class,'crear']);
$router->get('/admin/rutas/editar',[RutaController::class,'editar']);
$router->post('/admin/rutas/editar',[RutaController::class,'editar']);
$router->post('/admin/rutas/eliminar',[RutaController::class,'eliminar']);


//Devoluciones
$router->get('/admin/devoluciones',[DevolucionController::class,'index']);
$router->get('/admin/devoluciones/mostrar',[DevolucionController::class,'mostrar']);
$router->post('/admin/devoluciones/mostrar',[DevolucionController::class,'mostrar']);
$router->get('/admin/devoluciones/editar',[DevolucionController::class,'editar']);
$router->get('/admin/devoluciones/obtenerDev',[DevolucionController::class,'obtenerDev']);
$router->post('/admin/devoluciones/cancelarDev',[DevolucionController::class,'cancelarDev']);

//Usuarios
$router -> get('/admin/usuarios',[UsuarioController::class,'index']);
$router -> get('/admin/usuarios/crear',[UsuarioController::class,'crear']);
$router -> post('/admin/usuarios/crear',[UsuarioController::class,'crear']);
$router -> get('/admin/usuarios/editar',[UsuarioController::class,'editar']);
$router -> post('/admin/usuarios/editar',[UsuarioController::class,'editar']);
$router -> post('/admin/usuarios/eliminar',[UsuarioController::class,'eliminar']);
//API almacenes
$router -> get('/api/almacenes',[APIAlmacenes::class,'index']);

//Motivos dev
$router -> get('/admin/motivos',[MotivoController::class,'index']);
$router -> get('/admin/motivos/crear',[MotivoController::class,'crear']);
$router -> post('/admin/motivos/crear',[MotivoController::class,'crear']);
$router -> get('/admin/motivos/editar',[MotivoController::class,'editar']);
$router -> post('/admin/motivos/editar',[MotivoController::class,'editar']);
//Api para eliminar motivos
$router->post('/admin/motivos/eliminar', [MotivoController::class, 'eliminar']);




//APIPronosticos
$router -> get('/api/pronosticos',[APIPronosticos::class,'index']);

//APIDevoluciones
$router -> get('/api/facturas',[APIFacturas::class,'index']);
$router -> get('/api/facturas/mostrarMaterial',[APIFacturas::class,'mostrarMaterial']);



//Zona Choferes
$router->get('/choferes/index',[ChoferController::class,'index']);
$router->get('/choferes/index/formulario',[ChoferController::class,'crear_devolucion']);
$router->post('/choferes/index/formulario',[ChoferController::class,'crear_devolucion']);
$router->get('/choferes/index/devoluciones',[ChoferController::class,'mostrarDevoluciones']);
$router->post('/choferes/index/devoluciones',[ChoferController::class,'mostrarDevoluciones']);

//Zona Almacen
$router -> get('/almacen/index',[AlmacenController::class,'index']);
$router -> post('/almacen/index',[AlmacenController::class,'index']);

//Zona Jefes
$router -> get('/jefes/index',[JefesController::class,'index']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();