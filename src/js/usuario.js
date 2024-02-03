(function () {
  // Obtén una referencia al elemento select y el div donde se  ostraran los datos
  const select = document.querySelector("#tipousuario");
  const espacioIptionAlmacen = document.querySelector("#option-almacen");

  // Agrega un evento onchange para detectar cuando se selecciona una opción
  if (select) {
    select.onchange = function () {
      const option = select.value;
      if (option === "3") {
        obtenerAlmacenes();
      } else {
        limpiarOpcionesAlmacen();
      }
    };
  }

  function mostrarOpcionesAlmacen(almacen) {
    const opcionesAlmacen = document.createElement("DIV");
    opcionesAlmacen.classList.add("formulario__opciones");
    let html = "";
    almacen.forEach((almacen) => {
        //Concatenar para crear cada almacen
      html += `
          <div class="formulario__opciones">
            <label class="formulario__label" for="a${almacen.id}">${almacen.nombre}</label>
            <input class="formulario__radio" id="a${almacen.id}" value="${almacen.id}" name="id_almacen" type="radio">
          </div>
        `;
    });

    espacioIptionAlmacen.innerHTML = html;
    espacioIptionAlmacen.appendChild(opcionesAlmacen);
  }

  function limpiarOpcionesAlmacen() {
    while (espacioIptionAlmacen.firstChild) {
      espacioIptionAlmacen.removeChild(espacioIptionAlmacen.firstChild);
    }
  }

  async function obtenerAlmacenes() {
    try {
      const url = `/api/almacenes`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();
      //Mostrar los divs con los datos 
      mostrarOpcionesAlmacen(resultado);
    } catch (error) {
      console.error("Error en la solicitud:", error);
    }
  }
})();
