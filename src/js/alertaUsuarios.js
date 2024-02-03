(function () {
  const botonEliminar = document.querySelectorAll("#usuario");

  botonEliminar.forEach((boton) => {
    boton.onclick = function () {
      const usuarioId = this.getAttribute("data-id");
      confirmarEliminacion(usuarioId);
    };
  });

  function confirmarEliminacion(usuarioId) {
    Swal.fire({
      title: "¿Eliminar Usuario?",
      showCancelButton: true,
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        eliminarUsuario(usuarioId);
      }
    });
  }

  async function eliminarUsuario(usuarioId) {
    const datos = new FormData();
    datos.append("id", usuarioId);
    try {
      const url = "/admin/usuarios/eliminar";
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
})();
