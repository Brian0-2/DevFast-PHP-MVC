(function () {
  botonCancelar = document.querySelectorAll("#devolucion");
  console.log(botonCancelar);
  if (botonCancelar) {
    botonCancelar.forEach((boton) => {
      boton.onclick = function () {
        const devolucionId = this.getAttribute("data-id");
        confirmarCancelacion(devolucionId);
      };
    });
  }

  function confirmarCancelacion(id) {
    Swal.fire({
      title: "Cancelar Devolucion?",
      showCancelButton: true,
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        cancelarDevolucion(id);
      }
    });
  }

  async function cancelarDevolucion(id) {
    const datos = new FormData();
    datos.append("id", id);
    try {
      const url = "/admin/devoluciones/cancelarDev";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });
      const resultado = await respuesta.json();

      if (resultado.resultado) {
        Swal.fire({
          title: "Cancelado!",
          text: resultado.mensaje,
          icon: resultado.tipo,
          showConfirmButton: false, // Esto oculta el botón "OK"
        });
        setTimeout(() => {
          location.reload();
        }, 1000);
      } else {
        Swal.fire({
          title: "Error...",
          text: resultado.mensaje,
          icon: resultado.tipo,
        });
      }
    } catch (error) {
      console.log(error);
    }
  }
})();
