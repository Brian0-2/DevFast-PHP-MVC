(function () {
  const botonesEliminar = document.querySelectorAll("#motivo");
  if(botonesEliminar){
    botonesEliminar.forEach((boton) => {
      boton.onclick = function () {
        const motivoId = this.getAttribute("data-id");
  
        confirmarEliminarMotivo(motivoId);
      };
    });
  
    function confirmarEliminarMotivo(motivoId) {
      Swal.fire({
        title: "¿Eliminar Motivo?",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarMotivo(motivoId);
        }
      });
    }
  
    async function eliminarMotivo(motivoId) {
      const datos = new FormData();
      datos.append("id", motivoId);
      try {
        const url = "/admin/motivos/eliminar";
        const respuesta = await fetch(url, {
          method: "POST",
          body: datos,
        });
        const resultado = await respuesta.json();
        if (resultado.resultado) {
          Swal.fire("Eliminado!", resultado.mensaje, resultado.tipo);
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          Swal.fire("Alerta!", resultado.mensaje, resultado.tipo);
        }
      } catch (error) {
        console.error("Error en la solicitud:", error);
      }
    }
  }

})();
