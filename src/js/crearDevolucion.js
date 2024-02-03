(function () {
  const facturaInput = document.querySelector("#factura");
  const datosFacturaContainer = document.querySelector("#datos-factura");
  const listadoMateriales = document.querySelector("#listado-materiales");
  const materialHidden = document.querySelector('[name="id_material"]');
  const fieldsetMotivo = document.querySelector(
    ".formchofer__fieldset--ocultar"
  );

  let materialesFiltrados = [];

  if (facturaInput) {
    facturaInput.addEventListener("input", buscarFactura);
  }

  async function buscarFactura(e) {
    const busqueda = e.target.value;
    if (busqueda.length >= 6) {
      const factura = await obtenerFactura(facturaInput.value.trim());
      const materiales = await obtenerMaterial(facturaInput.value.trim());

      if (factura && materiales) {
        Swal.fire({
          icon: "success",
          title: "Filtrado correctamente...",
          showConfirmButton: false,
          toast: true,
          position: "top-end",
          timer: 1000,
        });
        // Si se encontraron datos de la factura, actualizar el formulario
        mostrarDatosFactura(factura);
        const materialInput = document.querySelector("#material");
        materialInput.addEventListener("input", buscarMateriales);
      } else {
        // Elimina los elementos anteriores dentro del contenedor
        limpiarDatosPrevios();
        materialesFiltrados = [];
        Swal.fire({
          icon: "error",
          title: "No existe la factura...",
          showConfirmButton: false,
          toast: true,
          position: "top-end",
          timer: 2000,
        });
      }

      function buscarMateriales(e) {
        const buscar = e.target.value;

        if (buscar.length > 2) {
          //adaptar la busqueda para mayusculas o minusculas
          const expresion = new RegExp(buscar, "i");
          materialesFiltrados = materiales.filter((material) => {
            //si retornala expresion -1 quiere decir que no encontro nada
            if (material.folio.toLowerCase().search(expresion) != -1) {
              return material;
            }
          });
        } else {
          materialesFiltrados = [];
          //Ocultar fieldset movivoDev
          fieldsetMotivo.classList.remove("formchofer__fieldset--mostrar");
        }
        // Si en el campo buscar hay mas de 3 caracteres o si los materiales filtrados esta vacio
        if (buscar.length > 2 && materialesFiltrados.length === 0) {
          fieldsetMotivo.classList.remove("formchofer__fieldset--mostrar");
          Swal.fire({
            icon: "error",
            title: "No existe material...",
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            timer: 2000,
          });
        }

        //Mostrar materiales
        mostrarMateriales();
      }

      function mostrarMateriales() {
        limpiarDatosMateriales();

        if (materialesFiltrados.length > 0) {
          materialesFiltrados.forEach((material) => {
            const materialHTML = document.createElement("LI");
            materialHTML.classList.add("listado-materiales__material");
            materialHTML.dataset.materialId = material.id;
            materialHTML.innerHTML = `
                        <p>Presiona para seleccionar.</p>
                            <label class="listado-materiales__material--label">Folio:</label>
                                <p class="listado-materiales__material--p">${material.folio}</p>
                            <label class="listado-materiales__material--label">Descripción:</label>
                                <p class="listado-materiales__material--p">${material.descripcion}</p>
                        `;

            materialHTML.onclick = seleccionarMaterial;
            listadoMateriales.appendChild(materialHTML);
            //Animaciones
            AOS.refreshHard();
          });
        }

        function seleccionarMaterial(e) {
          const material = this;
          // Comprueba si hay algún elemento con la clase antes de intentar eliminarla
          const materialPrevio = document.querySelector(
            ".listado-materiales__material--seleccionado"
          );
          if (materialPrevio) {
            materialPrevio.classList.remove(
              "listado-materiales__material--seleccionado"
            );
          }
          //Agregar estilos al ser seleccionado
          material.classList.add("listado-materiales__material--seleccionado");
          //Agregar el dato cuando se seleccione
          materialHidden.value = material.dataset.materialId;
          //Si hay un dato muestra el siguiente paso
          if (materialHidden.value) {
            fieldsetMotivo.classList.add("formchofer__fieldset--mostrar");
          }
        }
      }
    } else {
      //Limpiar factura
      limpiarDatosPrevios();
      materialesFiltrados = [];
      //limpiar material_id
      materialHidden.value = "";
      //Limpiar materiales
      limpiarDatosMateriales();
    }
  }

  function mostrarDatosFactura(factura) {
    limpiarDatosPrevios();
    const datosFactura = document.createElement("DIV");

    datosFactura.innerHTML = `
           <fieldset data-aos="fade-right" data-aos-once="true" data-aos-offset="300" data-aos-easing="ease-in-sine" class="formchofer__fieldset">
                <legend class="formchofer__legend">Datos del cliente</legend>
                    <label class="formchofer__label">Folio: <span class="formchofer__label--span"> ${factura.folio_cliente} </span></label>
                    <label class="formchofer__label">Nombre: <span class="formchofer__label--span"> ${factura.nombre_cliente} </span></label>

                    <input type="hidden" name="id_factura" value="${factura.id}"></input>
                    <input type="hidden" name="id_cliente" value="${factura.id_cliente}"></input>
            </fieldset>
            <fieldset class="formchofer__fieldset">
                <legend class="formchofer__legend">Ingresa folio del material</legend>
                <input data-aos="fade-left" data-aos-once="true" class="formchofer__input" placeholder="Presiona aquí..." id="material" type="text">
                <label data-aos="fade-left" data-aos-once="true" class="formchofer__label" id="material-label" for="material-data">Ingresa las piezas.</label>
                <input data-aos="fade-left" data-aos-once="true" class="formchofer__input" placeholder="Presiona aquí..." name="cantidadmaterial" id="material-data" type="number">
            </fieldset>
        `;

    document.querySelector("#datos-factura").appendChild(datosFactura);
    AOS.refreshHard();
  }

  function mostrarInputSubmit() {
    const selectSelected = document.getElementById("id_motivodev");
    const espacio = document.querySelector(".formchofer__boton");
    let botonCreado = false;

    if (selectSelected && espacio) {
      selectSelected.addEventListener("change", function () {
        if (!botonCreado) {
          // Verifica si el botón ya se ha creado
          const submit = document.createElement("INPUT");
          submit.type = "SUBMIT";
          submit.value = "Enviar devolución";
          submit.id = "id_boton";
          submit.classList.add("formchofer__submit");
          espacio.appendChild(submit);
          botonCreado = true;

          // Agrega un evento al botón
          const formulario = document.querySelector("#id_enviar");
          submit.addEventListener("click", function (e) {
            e.preventDefault();

            Swal.fire({
              title: "¿Estás seguro de enviar la devolución?",
              text: "Se enviará a Almacén...",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Sí, enviar",
              cancelButtonText: "No, cancelar",
            }).then((result) => {
              if (result.isConfirmed) {
                // El usuario confirmó, ahora puedes enviar el formulario
                const inputPiesas = document.querySelector("#material-data");

                if (inputPiesas) {
                  if (
                    inputPiesas.value.trim() === "" || inputPiesas.value.trim() === "0"
                  ) {
                    Swal.fire({
                      title: "Error, Falta llenar las piezas del Material...",
                      icon: "error",
                    });
                    inputPiesas.style.border = "3px solid red";
                    return;
                  }
                  const regex = /^\d+$/; // Esto permite solo números
                  if (!regex.test(inputPiesas.value.trim())) {
                    Swal.fire({
                      title:
                        "Error,La cantidad de piesas solo debe contener números...",
                      icon: "error",
                    });
                    inputPiesas.style.border = "3px solid red";
                    return;
                  }
                } else {
                  Swal.fire({
                    title: "Error",
                    icon: "error",
                  });

                  setTimeout(() => {
                    location.reload();
                  }, 3000);
                  return;
                }
              }

                Swal.fire({
                  title: "Exito!,Devolucion Creada!",
                  icon: "success",
                });
                setTimeout(() => {
                  formulario.submit();
                }, 1300);
         
            });
          });
        }
      });
    }
  }

  // Llama a mostrarInputSubmit() cuando la página esté lista
  document.addEventListener("DOMContentLoaded", function () {
    mostrarInputSubmit();
  });

  function limpiarDatosPrevios() {
    // Elimina los elementos anteriores dentro del contenedor
    while (datosFacturaContainer.firstChild) {
      datosFacturaContainer.removeChild(datosFacturaContainer.firstChild);
    }
  }

  function limpiarDatosMateriales() {
    while (listadoMateriales.firstChild) {
      listadoMateriales.removeChild(listadoMateriales.firstChild);
    }
  }

  // Obtener la factura
  async function obtenerFactura(folio) {
    const url = `/api/facturas?folio=${folio}`;
    const respuesta = await fetch(url);

    if (respuesta.ok) {
      const resultado = await respuesta.json();
      return resultado[0];
    } else {
      // Maneja el caso de error HTTP aquí si es necesario
      console.error(
        "Error HTTP al obtener la factura:",
        respuesta.status,
        respuesta.statusText
      );
      return null;
    }
  }

  async function obtenerMaterial(id) {
    const url = `/api/facturas/mostrarMaterial?id=${id}`;
    const respuesta = await fetch(url);
    if (respuesta.ok) {
      const resultado = await respuesta.json();
      return resultado;
    } else {
      // Maneja el caso de error HTTP aquí si es necesario
      console.error(
        "Error HTTP al obtener la factura:",
        respuesta.status,
        respuesta.statusText
      );
      return null;
    }
  }
})();
