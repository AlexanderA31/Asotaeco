document.addEventListener("DOMContentLoaded", async function () {
  // Variables para rastrear el número de elementos mostrados y el tamaño del bloque
  var miTabla = $("#miTabla").DataTable({
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron registros coincidentes",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": activar para ordenar la columna ascendente",
        sortDescending: ": activar para ordenar la columna descendente",
      },
    },

    lengthChange: false,
    pageLength: 5,
    columns: [
      {
        data: null,
        title: "Productos",
        render: function (data, type, row) {
          const guiaServi =
            data.guia_servi !== null
              ? `<h5 class="m-2 font-weight-bold">Guia de servientrega ${data.guia_servi}</h5>`
              : "";

          return `
            <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                <h5 class="mt-0 font-weight-bold mb-2">${data.fecha_venta}</h5> 
                <div class="media-body order-2 order-lg-1">
                    <h5 class="mt-0 font-weight-bold mb-2">${
                      data.nombre_producto
                    }</h5>
                    <p class="font-italic text-muted mb-0 small">${
                      data.descripcion_producto
                    }</p>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <h6 class="font-weight-bold my-2">${data.cantidad} X $${
            data.precio_unitario
          } = $${data.cantidad * data.precio_unitario}</h6>
                        <ul class="list-inline small">
                            <li>
                                <a href="../product-detail/index.php?id=${
                                  data.id_producto
                                }" class="btn btn-success m-2">Ver Producto</a>
                                <h5 class="m-2 font-weight-bold">${
                                  data.est_pago === 0
                                    ? "Pendiente"
                                    : data.est_pago === 1
                                    ? "Pagado Aprobado"
                                    : data.est_pago === 2
                                    ? "Enviado"
                                    : data.est_pago === 3
                                    ? "Entregado"
                                    : "Estado inválido"
                                }</h5>
                               ${guiaServi}
                                </li>
                        </ul>
                    </div>
                </div>
                <img src="${
                  data.imagen
                    ? data.imagen
                    : "../../public/images/products/defaultprod.png"
                }" alt="Product Image" width="100" height="100" class="ml-lg-5 order-1 order-lg-2" />
            </div>
          `;
        },
      },
    ],
  });
  timeS = 2000;
  reloadSection(null);
  // Agregar evento al botón "Ver Más"
  funcionBotones();
  function funcionBotones() {
    const compras = document.getElementById("btncompras");
    const pendiente = document.getElementById("btnpendiente");
    const pagado = document.getElementById("btnpagado");
    const entregados = document.getElementById("btnentregado");

    compras.addEventListener("click", function () {
      reloadSection(null);
    });
    pagado.addEventListener("click", function () {
      reloadSection(1);
    });
    pendiente.addEventListener("click", function () {
      reloadSection(0);
    });
    entregados.addEventListener("click", function () {
      reloadSection(2);
    });
  }

  async function reloadSection(id) {
    event.preventDefault();
    miTabla.clear().draw();
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsCliente&id=" + id
      );
      const responseData = await response.json();
      responseData.forEach((obj) => {
        miTabla.row.add(obj);
      });
      miTabla.draw();
      setLoading(false);
    } catch (error) {
      //console.error("Error al obtener productos:", error);
    }
  }
});
