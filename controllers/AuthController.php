<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\ActiveRecord;

class AuthController extends ActiveRecord
{

    public static function index(Router $router)
    {
        $alertas = [];
        //carpeta / archivo
        $router->render('auth/index', [
            'titulo' => 'Login',
            'alertas' => $alertas
        ]);
    }

    public static function login(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

             $_POST = sanitizarPost($_POST);

            // Crear un nuevo objeto Usuario con los datos sanitizados
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // Verificar quel el usuario exista
                $usuario = Usuario::where('nombre', $usuario->nombre);
                if (!$usuario) {
                    Usuario::setAlerta('error', 'El Usuario No Existe');
                } else {
                    // El Usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // if ($_POST['password'] === $usuario->password) {

                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['tipousuario'] = $usuario->tipousuario ?? null;
                        $_SESSION['id_almacen'] = $usuario->id_almacen ?? null;
                        $_SESSION['login'] = true;

                        // Redirección segura usando la función header
                        $destino = '/';
                        //Redireccion
                        if ($usuario->tipousuario === "1") {
                            header('Location: /admin/index');
                            exit;
                        } elseif ($usuario->tipousuario === '2') {
                            header('Location: /jefes/index');
                            exit;
                        } elseif ($usuario->tipousuario === '3') {
                            header('Location: /almacen/index');
                            exit;
                        } else {
                            header('Location: /choferes/index');
                            exit;
                        }

                        ob_clean();
                        header('Location: ' . $destino);
                        exit;
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista 
        $router->render('auth/index', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
}
