<?php
//Debuguear variables
function dd($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
// Escapa / Sanitizar el HTML
function s($html): string
{
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
}
//Sanitisar POST
function sanitizarPost($data)
{
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}
//$path es la ruta a la cual queremos encontrar
function pagina_actual($path): bool
{
    //ruta actual en la que este el proyecto
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}
// Función que revisa que el usuario este autenticado
function isAdmin(): void
{
    if (!isset($_SESSION['login']) || !$_SESSION['tipousuario'] === '1') {
        header('Location: /');
    }
}
// Función que revisa que el usuario este autenticado
function isChofer(): void
{
    if (!isset($_SESSION['login']) || !$_SESSION['tipousuario'] === '0') {
        header('Location: /');
    }
}

// Función que revisa que el usuario este autenticado
function isJefe(): void
{
    if (!isset($_SESSION['login']) || !$_SESSION['tipousuario'] === '2') {
        header('Location: /');
    }
}

// Función que revisa que el usuario este autenticado
function isAlmacen(): void
{
    if (!isset($_SESSION['login']) || !$_SESSION['tipousuario'] === '3') {
        header('Location: /');
    }
}

//Animaciones 
function aos_animation() : void{
    $efectos = ['fade-up','fade-down','fade-left','fade-right','flip-left','flip-right','zoom-in','zoom-in-up','zoom-in-down','zoom-out'];

  //Retorname 1 efecto aleatorio
  $efecto = array_rand($efectos,1);
  echo ' data-aos="'.$efectos[$efecto].'" ';

}