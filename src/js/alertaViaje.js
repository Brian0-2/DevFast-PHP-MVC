(function () {
  const botonEliminar = document.querySelectorAll("#viaje");
  if (botonEliminar) {
    botonEliminar.forEach((boton) => {
      boton.onclick = function () {
        const viajeId = this.getAttribute("data-id");
        confirmarEliminacion(viajeId);
      };
    });
    function confirmarEliminacion(viajeId) {
      Swal.fire({
        title: "¿Eliminar Viaje?",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarViaje(viajeId);
        }
      });
    }

    async function eliminarViaje(viajeId) {
      const datos = new FormData();
      datos.append("id", viajeId);
      try {
        const url = '/admin/index/eliminar';
        const respuesta = await fetch(url,{
            method: "POST",
            body: datos,
        });
        const resultado = await respuesta.json();
        if(resultado.resultado){
            Swal.fire({
                title: "Eliminado!",
                text: resultado.mensaje,
                icon: resultado.tipo,
                showConfirmButton: false  // Esto oculta el botón "OK"
              });
              
            setTimeout(() => {
                location.reload();
              }, 1000);
        }else{
            Swal.fire({
                title: "Alerta!",
                text: resultado.mensaje,
                icon: resultado.tipo
              });
              
        }
      } catch (error) {
        console.error("Error en la solicitud:", error);
      }
    }
  }
})();
