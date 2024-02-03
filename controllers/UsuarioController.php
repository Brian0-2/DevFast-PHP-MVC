<?php

namespace Controllers;

use MVC\Router;
use Model\Viaje;
use Model\Almacen;
use Model\Usuario;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;


class UsuarioController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();

        $alertas = [];

        $pagina_actual = $_GET['page'];
        $_GET = sanitizarPost($_GET);


        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        //Garantizar que estamos en la pagina actual correcta
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/usuarios?page=1');
        }

        $registros_por_pagina = 10;
        $total = Usuario::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/usuarios?page=1');
        }

        $usuarios = Usuario::paginar('id, nombre, imagen , tipousuario', ' WHERE tipousuario != 1', $registros_por_pagina, $paginacion->offset(), 'DESC');

        $router->render('/admin/usuarios/index', [
            'titulo' => 'Usuarios',
            'alertas' => $alertas,
            'usuarios' => $usuarios,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function editar(Router $router)
    {
        session_start();
        isAdmin();

        $id = $_GET['id'];
        $alertas = [];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/index');
            exit;
        }
        $_GET = sanitizarPost($_GET);


        $usuario = Usuario::find($id);

        //Traerme el almacen si el usuario pertenece a un almacen
        if ($usuario->tipousuario === '3') {
            $almacenes = Almacen::all();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST = sanitizarPost($_POST);

            if (password_verify($_POST['password'], $usuario->password)) {

                //Verificar el contenido de los campos sea el mismo
                if (!empty($_POST['password_new'] !== $_POST['password_repeat'])) {
                    Usuario::setAlerta('error', 'La nueva contraseña no es igual a la repetida');
                }
                // Verificar si se ha enviado una nueva imagen
                if (!empty($_FILES['imagen']['tmp_name'])) {
                    //formato de la imagen
                    $tipoImagen = mime_content_type($_FILES['imagen']['tmp_name']);

                    if ($tipoImagen === 'image/jpeg' || $tipoImagen === 'image/png' || $tipoImagen === 'image/gif') {
                        $carpeta_imagenes = '../public/img/users';

                        // Elimina la imagen anterior asociada al usuario
                        $imagen_anterior_png = $carpeta_imagenes . '/' . $usuario->imagen . ".png";
                        $imagen_anterior_webp = $carpeta_imagenes . '/' . $usuario->imagen . ".webp";

                        //Si existe la imagen borrala .png
                        if (file_exists($imagen_anterior_png)) {
                            unlink($imagen_anterior_png);
                        }

                        //Si existe la imagen borrala .webp
                        if (file_exists($imagen_anterior_webp)) {
                            unlink($imagen_anterior_webp);
                        }

                        // Carga y guarda la nueva imagen
                        $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                        $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                        //Nombre unico a la imagen
                        $nombre_imagen = md5(uniqid(rand(), true));
                        $usuario->imagen = $nombre_imagen;

                        //Guardar la imagen con la ruta y extencion
                        $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                        $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                    } else {
                        $alertas = Usuario::setAlerta('error', 'El formato de la imagen no es valido....');
                    }
                }

                //si no es encargado de almacen
                if ($usuario->tipousuario != '3') {
                    //Asignarlo a no pertenece
                    $usuario->id_almacen = 5;
                }


                if ($usuario) {
                    //Validar que el usuario ya haya estado registrado con viajes
                    $viaje = Viaje::where('id_usuario', $usuario->id);
                    if ($viaje) {
                        if ($viaje->id_usuario === $usuario->id) {
                            if ($_POST['tipousuario'] !== '0') {
                                $alertas = Viaje::setAlerta('error', 'El tipo de usuario no se puede cambiar, el usuario ya a hecho viajes...');
                            }
                        }
                    }
                }

                // Actualiza el registro del usuario en la base de datos
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validar();

                //Verificar que no esten vacios los campos y asignar nueva contraseña
                if (!empty($_POST['password_new'] && !empty($_POST['password_repeat']))) {
                    $usuario->password = $_POST['password_new'];
                }

                $usuario->hashPassword();

                if (empty($alertas)) {

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /admin/usuarios');
                        exit;
                    }
                }
            } else {
                Usuario::setAlerta('error', 'La contraseña actual no es correcta...');
            }


        }
        $alertas = Viaje::getAlertas();
        $alertas = Usuario::getAlertas();

        $router->render('/admin/usuarios/editar', [
            'titulo' => 'Editar usuario',
            'alertas' => $alertas,
            'usuario' => $usuario,
            'almacenes' => $almacenes ?? []
        ]);
    }


    public static function crear(Router $router)
    {
        session_start();
        isAdmin();
        $usuario = new Usuario();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = sanitizarPost($_POST);

            //validar campos nuevos para la contraseña
            if ($_POST['password'] != $_POST['password_repeat']) {
                Usuario::setAlerta('error', 'La contraseña no es igual');
            }
            //leer imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                //formato de la imagen
                $tipoImagen = mime_content_type($_FILES['imagen']['tmp_name']);

                //Validar los formatos de imagen validos
                if ($tipoImagen === 'image/jpeg' || $tipoImagen === 'image/png' || $tipoImagen === 'image/gif') {
                    $carpeta_imagenes = '../public/img/users';

                    //crear la carpeta si no existe
                    if (!is_dir($carpeta_imagenes)) {
                        mkdir($carpeta_imagenes, 0777, true);
                    }
                    //Crear imagen
                    $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                    $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                    //Dar nombre unico a las imagenes
                    $nombre_imagen = md5(uniqid(rand(), true));
                    $_POST['imagen'] = $nombre_imagen;

                    //Guardar la imagen con la ruta y extencion
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                } else {
                    $alertas = Usuario::setAlerta('error', 'El formato de la imagen no es valido....');
                }
            }

            $usuario->sincronizar($_POST);

            //Validar
            $alertas = $usuario->validar();

            //si no es encargado de almacen
            if ($usuario->tipousuario != '3') {
                //Asignarlo a no pertenece
                $usuario->id_almacen = 5;
            }

            //Guardar el registro
            if (empty($alertas)) {
                $usuario->hashPassword();

                //Guardar en la DB
                $resultado = $usuario->guardar();

                //Redireccionar
                if ($resultado) {
                    header('Location: /admin/usuarios');
                    exit;
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('/admin/usuarios/crear', [
            'titulo' => 'Nuevo usuario',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function eliminar(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            //Revisar que hayan iniciado session.
            if (!$_SESSION) {
                echo json_encode(['...']);
                return;
            }
            $_POST = sanitizarPost($_POST);
            $idPost = $_POST['id'];
            $usuario = Usuario::find($idPost . ' LIMIT 1');
            //Si el id del usuario no existe
            if (!$usuario) {
                $resultado = [
                    'tipo' => 'error',
                    'mensaje' => 'El usuario a eliminar no existe...'
                ];

                echo json_encode($resultado);
                return;
            }

            $viaje = Viaje::where('id_usuario', $usuario->id, 'LIMIT 1');
            //Validar que el usuario no este ya en un viaje dado de alta
            if ($viaje) {
                $resultado = [
                    'tipo' => 'error',
                    'mensaje' => 'El usuario: ' . $usuario->nombre . ', ya pertenece a un viaje y no se puede borrar...'
                ];

                echo json_encode($resultado);
                return;
            }

            $user = new Usuario($_POST);

            $resultado = $user->eliminar();

            if ($resultado) {
                // Elimina el registro del usuario de la base de datos
                // Obtén las imágenes asociadas a este usuario
                $imagenes = [$usuario->imagen . ".png", $usuario->imagen . ".webp"];
                $carpeta_imagenes = '../public/img/users';

                foreach ($imagenes as $imagen) {
                    $imagen_path = $carpeta_imagenes . '/' . $imagen;
                    if (file_exists($imagen_path)) {
                        // Elimina la imagen si existe en el servidor
                        unlink($imagen_path);
                    }
                }

                $resultado = [
                    'resultado' => $resultado,
                    'tipo' => 'success',
                    'mensaje' => 'El usuario: ' . $usuario->nombre . ', se borro correctamente'
                ];

                echo json_encode($resultado);
                return;
            }
        }
    }
}
