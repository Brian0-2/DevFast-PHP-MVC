    <div class="filtro">
            <div class="filtro__seccion">
                <label class="filtro__label" for="select-year">Seleccionar Año:</label>
                <select class="filtro__select" id="select-year">
                <option value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
                    <option selected value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                </select>
            </div><!--Fin.seccion-->

            <div class="filtro__seccion">
                <label class="filtro__label" for="select-month">Seleccionar Mes:</label>
                <select class="filtro__select" require id="select-month">
                    <option selected disabled value="">Seleccione</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>


            </div><!--Fin.seccion-->
            <button class="filtro__boton filtro__boton--pronostico" type="button" id="btnFiltrar">Filtrar</button>

        </div><!--Fin.filtros-opciones-->
    </div>