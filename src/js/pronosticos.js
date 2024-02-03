(function () {
  const grafica = document.querySelector("#pronosticos-grafica");

  if (grafica) {
    //Mi grafico si no exixte
    let myChart = null;
    document.querySelector("#btnFiltrar").addEventListener("click", function () {
      const yearSelected = document.querySelector("#select-year").value;
      const monthSelected = document.querySelector("#select-month").value;

      // Realiza una llamada a la API para obtener las tareas filtradas
      obtenerDatos(yearSelected, monthSelected);
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Filtrado Correctamente...", 
        showConfirmButton: false,
        backdrop: false,
        timer: 1000,
      });
    });

    //Si no hay nada mandala a llamar
    obtenerDatos();
    async function obtenerDatos(year, month) {
      const url = `/api/pronosticos?year=${year}&month=${month}`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      const ctx = document
        .getElementById("pronosticos-grafica")
        .getContext("2d");
      // Verifica si ya existe un gráfico y destrúyelo si es necesario
      if (myChart) {
        myChart.destroy();
      }

      myChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: resultado.map((motivodev) => motivodev.motivo),
          datasets: [
            {
              data: resultado.map((motivodev) => motivodev.total),
              backgroundColor: [
                "#0000CD",
                "#800000",
                "#000000",
                "#2563EB",
                "#ff5500",
                "#DB2777",
                "#008000",
                "#FFD700",
                "#64748B",
                "#ff0000",
                "#1B4125",
                "#C9AE5D",
                "#FF2000",
                "#3B3121",
                "#00FF00",
                "#6A0DAD",
              ],
              borderWidth: 1,
              annotations: {
                annotations: resultado.map((motivodev, index) => ({
                  type: "line",
                  mode: "vertical",
                  scaleID: "x",
                  value: index,
                  borderColor: "black",
                  borderWidth: 1,
                  label: {
                    content: motivodev.total,
                    enabled: true,
                    position: "top",
                  },
                })),
              },
            },
          ],
        },
        options: {
          scales: {
            x: {
              barPercentage: 0.8,
              title: {
                display: true,
                text: "Motivos",
              },
              ticks: {
                font: {
                  size: 16, // Tamaño de fuente para el eje X
                  weight: 'bold', // Peso de fuente
                  family: 'Arial', // Familia de fuente
                  color: 'red' // Color del texto
                },
              },
            },
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: "Total",
              },
              ticks: {
                font: {
                  size: 16, // Tamaño de fuente para el eje Y
                  weight: 'bold', // Peso de fuente
                  family: 'Arial', // Familia de fuente
                  color: 'blue' // Color del texto
                },
              },
            },
          },
          plugins: {
            legend: {
              display: false,
            },
          },
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 10,
              bottom: 10,
            },
          },
        },
      });
    }
  }
})();
