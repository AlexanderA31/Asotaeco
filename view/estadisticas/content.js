document.addEventListener("DOMContentLoaded", async function () {
  timeS = 2000;

  reloadSection();
  function reloadSection() {
    try {
      const vMes = document.getElementById("v_mes");
      const PvMes = document.getElementById("porc_v_mes");

      const vt_mes = document.getElementById("vt_mes");
      const pvt_mes = document.getElementById("pvt_mes");

      const g_anual = document.getElementById("g_anual");
      const pg_anual = document.getElementById("pg_anual");

      const pclientes = document.getElementById("porc_clientes");
      const clientes = document.getElementById("clientes");

      fetch("../../controllers/router.php?op=getEstadisticas").then(
        (response) => {
          if (!response.ok) {
            throw new Error("Hubo un problema al obtener las estadísticas.");
          }
          response.json().then((data) => {
            if (data.ventasMensuales.length > 0) {
              const ventasMes = data.ventasMensuales[0];
              console.log(ventasMes);
              vMes.textContent = `$${ventasMes.gananciasEsteMes}`;
              let porcentaje, icono, clase;

              if (ventasMes.gananciasEsteMes !== 0) {
                porcentaje =
                  (ventasMes.gananciasEsteMes * 100) /
                  ventasMes.gananciasMesAnterior;
              } else {
                porcentaje = -100;
              }
              if (!isFinite(porcentaje)) {
                porcentaje = 100;
              }
              if (porcentaje >= 0) {
                icono = '<i class="fa fa-arrow-up"></i>';
                clase = "text-success";
              } else {
                icono = '<i class="fas fa-arrow-down"></i>';
                clase = "text-danger";
              }

              let porcentajepvt = 0;

              if (ventasMes.ventasEsteMes !== 0) {
                porcentajepvt =
                  (ventasMes.ventasEsteMes * 100) / ventasMes.ventasMesAnterior;
              } else {
                porcentajepvt = -100;
              }
              if (!isFinite(porcentajepvt)) {
                porcentajepvt = 100;
              }
              if (porcentajepvt >= 0) {
                icono = '<i class="fa fa-arrow-up"></i>';
                clase = "text-success";
              } else {
                icono = '<i class="fas fa-arrow-down"></i>';
                clase = "text-danger";
              }
              vt_mes.textContent = `${ventasMes.ventasEsteMes}`;
              pvt_mes.innerHTML = `${icono} <span class="${clase}">${Math.abs(
                porcentajepvt
              ).toFixed(2)}%</span>`;

              PvMes.innerHTML = `${icono} <span class="${clase}">${Math.abs(
                porcentaje
              ).toFixed(2)}%</span>`;
            }
            if (data.nuevosClientes.length > 0) {
              const nuevosClientes = data.nuevosClientes[0];
              clientes.textContent =
                `${nuevosClientes.nuevosClientesEsteMes}` +
                "/" +
                `${nuevosClientes.totalClientes}`;
              let porcentaje, icono, clase;

              if (nuevosClientes.nuevosClientesEsteMes !== 0) {
                porcentaje =
                  (nuevosClientes.nuevosClientesEsteMes * 100) /
                  nuevosClientes.nuevosClientesMesAnterior;
              } else {
                porcentaje = -100;
              }
              if (!isFinite(porcentaje)) {
                porcentaje = 100;
              }

              if (porcentaje >= 0) {
                icono = '<i class="fa fa-arrow-up"></i>';
                clase = "text-success";
              } else {
                icono = '<i class="fas fa-arrow-down"></i>';
                clase = "text-danger";
              }
              pclientes.innerHTML = `${icono} <span class="${clase}">${Math.abs(
                porcentaje
              ).toFixed(2)}%</span>`;
            }
            if (data.ventasAnuales.length > 0) {
              const ventasMes = data.ventasAnuales[0];
              g_anual.textContent = `$${ventasMes.ventasAnioActual}`;
              let porcentaje, icono, clase;

              if (ventasMes.ventasAnioActual !== 0) {
                porcentaje =
                  (ventasMes.ventasAnioActual * 100) /
                  ventasMes.ventasAnioAnterior;
              } else {
                porcentaje = -100;
              }
              if (!isFinite(porcentaje)) {
                porcentaje = 100;
              }
              if (porcentaje >= 0) {
                icono = '<i class="fa fa-arrow-up"></i>';
                clase = "text-success";
              } else {
                icono = '<i class="fas fa-arrow-down"></i>';
                clase = "text-danger";
              }

              pg_anual.innerHTML = `${icono} <span class="${clase}">${Math.abs(
                porcentaje
              ).toFixed(2)}%</span>`;
              setLoading(false);
            }
          });
        }
      );
    } catch (error) {
      setLoading(false);
      console.error("Error al obtener las estadísticas:", error);
    }
  }
});
