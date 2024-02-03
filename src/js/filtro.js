(function () {
  // Filtrado para la tabla
  const filtroTablaInput = document.querySelector("#filtro");
  const filasTabla = document.querySelectorAll(".table__tr");

  if (filtroTablaInput) {
    filtroTablaInput.addEventListener("input", function () {
      const filtro = filtroTablaInput.value.toLowerCase();

      filasTabla.forEach(function (fila) {
        const motivo = fila
          .querySelector(".table__td:nth-child(2)")
          .textContent.toLowerCase();

        if (motivo.includes(filtro)) {
          fila.style.display = "";
        } else {
          fila.style.display = "none";
        }
      });
    });
  }

  // Filtrado para la lista
  const filtroListaInput = document.querySelector("#filtro");
  const elementosLista = document.querySelectorAll(".listado-devs__viaje");

  if (filtroListaInput) {
    filtroListaInput.addEventListener("input", function () {
      const filtro = filtroListaInput.value.toLowerCase();

      elementosLista.forEach(function (elemento) {
        const nombre = elemento.textContent.toLowerCase();

        if (nombre.includes(filtro)) {
          elemento.style.display = "block";
        } else {
          elemento.style.display = "none";
        }
      });
    });
  }
})();
