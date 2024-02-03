(function () {
  const text = document.querySelector("#descripcion");

  if (text) {
    text.addEventListener("input", function (e) {
      const evento = e.target.value;
      const caracteresSinEspacios = evento.replace(/\s/g, "").length;

      // Muestra la cantidad de caracteres en tiempo real
      document.querySelector(
        "#contadorCaracteres"
      ).textContent = `Caracteres: ${caracteresSinEspacios}`;

      // Cambia el color del text cuando se alcanzan los 30 caracteres sin espacios
      if (caracteresSinEspacios >= 30) {
        text.style.backgroundColor = "#88ff88";
      } else {
        text.style.backgroundColor = ""; // Restablece el color predeterminado
      }
    });
  }
})();
