<?php include_once __DIR__ . '/../../templates/admin-header.php'; ?>
<div class="contenedor">
       <div <?php aos_animation(); ?> class="chofer">
              <a class="chofer__boton" href="/choferes/index">
                     <i class="fa-solid fa-circle-arrow-left"></i></i>
                     Volver
              </a>
       </div>
       <form id="id_enviar" class="formchofer" method="POST">
              <?php require_once __DIR__ . '/../../templates/alertas.php'; ?>
              <fieldset data-aos="fade-right" class="formchofer__fieldset">
                     <legend class="formchofer__legend">Ingresa el folio de la factura.</legend>
                     <input data-aos="fade-left" class="formchofer__input" placeholder="Presiona aquí..." id="factura" maxlength="6" type="text">
              </fieldset>
              <div class="formchofer__datos" id="datos-factura"> </div>
              <div class="formchofer__datos" id="datos-material"> </div>
              <ul data-aos="fade-up" data-aos-once="true" class="listado-materiales" id="listado-materiales"></ul>

              <input type="hidden" name="id_material" value="">
              <input type="hidden" name="id_viaje" value="<?php echo $id_viaje->id; ?>">
                                                                           <!--mostrar -->
              <fieldset <?php aos_animation(); ?> class="formchofer__fieldset--ocultar">
                     <legend <?php aos_animation(); ?> class="formchofer__legend">Motivo de devolución.</legend>
                     <p>Presiona para seleccionar</p>
                     <select <?php aos_animation(); ?> class="formchofer__select" name="id_motivodev" id="id_motivodev">
                            <option class="formchofer__option" disabled selected value="">--Selecciona--</option>
                            <?php foreach ($motivodev as $motivo) { ?>
                                   <option class="formchofer__option" value="<?php echo $motivo->id; ?>"><?php echo $motivo->motivo; ?></option>
                            <?php } ?>
                     </select>

                     <label <?php aos_animation(); ?> class="formchofer__label" for="descripcion">Describe el motivo</label>
                     <div id="contadorCaracteres"></div>
                     <textarea <?php aos_animation(); ?> class="formchofer__text-area" name="descripcion" id="descripcion" cols="30" rows="10" placeholder="Presiona aquí..."></textarea>

              </fieldset>
              <div class="formchofer__boton"></div>
       </form>
</div>