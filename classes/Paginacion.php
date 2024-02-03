<?php

namespace Classes;

class Paginacion
{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0)
    {
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    //Calculo para paginar 10 registros por numero de paginas - 1
    public function offset()
    {
        //registrosXPagina = 10 / paginaActual = 1 / (10 * (1 - 1)) = (10 * 0) = 0
        //registrosXPagina = 10 / paginaActual = 1 / (10 * (2 - 1)) = (10 * 1) = 10
        //registrosXPagina = 10 / paginaActual = 1 / (10 * (3 - 1)) = (10 * 2) = 20
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    public function total_paginas()
    {
        //ceil : redondea siempre hacia arriva para que en las diviciones de paginas no haya decimales
        // totalRegistros = (total baseDatos) / registros_por_pagina = 5 / (20 / 5) = 4 paginaciones;
        // totalRegistros = (total baseDatos) / registros_por_pagina = 5 / (22 / 5) = 4.4 Redondea a 5 paginaciones;
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_anterior()
    {
        $anterior = $this->pagina_actual - 1;
        //Validar que en la pagina 1 no nos lleve a la pagina 0
        //if(anterior >  0) = anterior es mayor a 1 o es 1
        //else, anterior va a ser( 0 o -algo) devuelve falso
        return ($anterior) > 0 ? $anterior : false;
    }

    public function pagina_siguiente()
    {
        $siguiente = $this->pagina_actual + 1;
        //Validar que el tortal de paginas no sea mayor al total de registros que se hicieron o hay en la DB
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_anterior()
    {
        //Si es posible ejecuta esto
        $html = '';
        if ($this->pagina_anterior()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlace_siguiente()
    {
        //Si es posible ejecuta esto
        $html = '';
        if ($this->pagina_siguiente()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    public function numeros_paginas()
    {
        $html = '';
        $total_paginas = $this->total_paginas();

        // Mostrar hasta 5 páginas antes o después de la página actual
        $max_links = 5;

        $inicio = max(1, min($this->pagina_actual - floor($max_links / 2), $total_paginas - $max_links + 1));
        $fin = min($total_paginas, $inicio + $max_links - 1);

        $inicio = max(1, min($this->pagina_actual - floor($max_links / 2), $total_paginas - $max_links + 1));
        // Estas líneas calcula el número de la primera página que se mostrará. Veámoslo paso a paso:

        // $this->pagina_actual - floor($max_links / 2): 
// Resta la mitad de la cantidad máxima de enlaces permitidos 
// desde la página actual. Esto ayuda a centrar los enlaces alrededor de la página actual.

        // min(..., $total_paginas - $max_links + 1): 
// Luego, usa la función min para asegurarse de que el resultado anterior no sea menor que 1 y 
//que no se vaya más allá del límite superior de páginas. 
//Esto garantiza que la primera página no sea menor que 1 y que no se vaya más allá del límite superior permitido.

        // $fin = min($total_paginas, $inicio + $max_links - 1);
//Esta línea calcula el número de la última página que se mostrará. Similar al paso anterior:

        // $inicio + $max_links - 1: 
// Suma la cantidad máxima de enlaces permitidos a la página de inicio y resta 1. 
//Esto da el límite superior de las páginas que se mostrarán.

        // min(..., $total_paginas): 
// Utiliza la función min nuevamente para asegurarse de que el límite superior calculado
// no sea mayor que el número total de páginas.

        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i === $this->pagina_actual) {
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual \">{$i}</span>";
            } else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";
            }
        }

        // Mostrar puntos suspensivos y enlace al último registro si hay más de 5 páginas
        if ($total_paginas > $max_links) {
            if ($inicio > 1) {
                $html = "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=1\">1</a> ... " . $html;
            }

            if ($fin < $total_paginas) {
                $html .= " ... <a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$total_paginas}\">{$total_paginas}</a>";
            }
        }

        return $html;
    }



    public function paginacion()
    {
        $html = '';
        if ($this->total_registros > 1) {
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }
        return $html;
    }
}
