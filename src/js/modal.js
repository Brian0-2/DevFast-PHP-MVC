(function () {
  const detalleBTN = document.querySelectorAll(".table__accion--detalle");
  let modalExistente = null;
  let devolucion = [];

  if (detalleBTN) {
    detalleBTN.forEach((id) => {
      id.onclick = function () {
        const devolucionId = this.getAttribute("data-id");
        if (!modalExistente) {
          obtenerDevolucion(devolucionId);
        }
      };
    });
  }

  function mostrarModal(devolucion) {
    if (modalExistente) {
      return;
    }
    const modal = document.createElement("DIV");
    modal.classList.add("modal");
    modal.innerHTML = `
        <div class="vista-modal">
            <p>id: ${devolucion[0].id}</p>
            <button type="button" class="cerrar-modal">Cancelar</button>
        </div>
    `;

    document.querySelector(".dashboard").appendChild(modal);

    setTimeout(() => {
      const vista = document.querySelector(".vista-modal");
      vista.classList.add("animar");
    }, 500);

    modal.addEventListener("click", function (e) {
      e.preventDefault();
      if (e.target.classList.contains("cerrar-modal")) {
        const vista = document.querySelector(".vista-modal");
        vista.classList.add("cerrar");
        setTimeout(() => {
          modal.remove();
          modalExistente = null;
        }, 500);
      }
    });

    modalExistente = modal;
  }

  function cerrarModal() {
    const vista = document.querySelector(".vista-modal");
    vista.classList.add("cerrar");
    setTimeout(() => {
      modalExistente.remove();
      modalExistente = null;
    }, 500);
  }

  async function obtenerDevolucion(id) {
    try {
      const url = `/admin/devoluciones/obtenerDev?id=${id}`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      devolucion = [...resultado];
      mostrarModal(devolucion);
    } catch (error) {
      console.log("error en la peticion", error);
    }
  }

  document.addEventListener("click", function (e) {
    if (modalExistente && !e.target.closest(".vista-modal")) {
      cerrarModal();
    }
  });
})();
