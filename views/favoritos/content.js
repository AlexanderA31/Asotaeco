document.addEventListener("DOMContentLoaded", async function () {
  // document
  //   .getElementById("btnpagar")
  //   .addEventListener("click", async function () {
  //     swal({
  //       title: "¿Esta seguro de realizar la compra?",
  //       text: "La acción se realizó de manera exitosa!",
  //       icon: "warning",
  //       buttons: ["Cancelar", "Confirmar"],
  //     }).then((confirmado) => {
  //       if (confirmado) {
  //         realizarPago();
  //       }
  //     });
  //   });
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
  
    lengthChange: false, // Desactivamos la opción de cambiar la cantidad de registros por página
    searching: false, // Desactivamos la búsqueda
    columns: [
      {
        data: "url_imagen",
        title: "Imagen",
        render: function (data, type, row) {
          return `<img src="${data}" alt="imagen del producto" width="50" />`;
        },
      },
      { data: "nombre", title: "Producto" }, // Nombre del producto

      { data: "descripcion", title: "Descipcion" },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return ` <a href="../product-detail/index.php?id=${row.id_producto}" class="btn btn-outline-info btnView" data-id="${row.id}">
          <i class="fa fa-eye" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });

  reloadSection();

  async function reloadSection() {
    try {
      miTabla.clear().draw(); // Limpiar la tabla antes de insertar nuevos datos

      const response = await fetch(
        "../../controllers/router.php?op=getWishClient"
      );
      data = await response.json();
      miTabla.rows.add(data).draw();
      setLoading(false);
    } catch (error) {
      setLoading(false);
      console.error("Error al obtener productos:", error);
    }
   

  }

  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    const formData = new FormData();
    formData.append("id", rowData.id_fav);
    fetch("../../controllers/router.php?op=deleteWishClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        
        if (response.ok) {
          reloadSection();
          swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });
});
