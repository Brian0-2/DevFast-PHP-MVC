(function () {
  const botonEliminar = document.querySelectorAll("#ruta");
  if (botonEliminar) {
    botonEliminar.forEach((boton) => {
      boton.onclick = function () {
        const rutaId = this.getAttribute("data-id");
        confirmarEliminacion(rutaId);
      };
    });

    function confirmarEliminacion(rutaId) {
      Swal.fire({
        title: "¿Eliminar Ruta?",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarRuta(rutaId);
        }
      });
    }
    async function eliminarRuta(rutaId) {
      const datos = new FormData();
      datos.append("id", rutaId);
      try {
        const url = "/admin/rutas/eliminar";
        const respuesta = await fetch(url, {
          method: "POST",
          body: datos,
        });
        const resultado = await respuesta.json();
        if (resultado.resultado) {
          Swal.fire({
            title: "Eliminado!",
            text: resultado.mensaje,
            icon: resultado.tipo,
            showConfirmButton: false, // Esto oculta el botón "OK"
          });

          setTimeout(() => {
            location.reload();
          }, 1000);
          
        } else {
          Swal.fire({
            title: "Alerta!",
            text: resultado.mensaje,
            icon: resultado.tipo,
          });
        }
      } catch (error) {
        console.error("Error en la solicitud:", error);
      }
    }
  }
})();
