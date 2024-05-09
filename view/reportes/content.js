document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertSlider cuando se hace clic en el botón
  });

  // Inicializar DataTables
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
    dom: "Bfrtip", // Agregar los botones de descarga
    buttons: [
      "copyHtml5", // Botón de copiar
      "excelHtml5", // Botón de Excel
      "csvHtml5", // Botón de CSV
      "pdfHtml5", // Botón de PDF
    ],
    lengthChange: false,
columns: [
      { data: "titulo" },
      { data: "descripcion" },
      {
        data: "img",
        title: "Imagen",
        render: function (data, type, row) {
          if (data) {
            return (
              '<img src="' +
              data +
              '" alt="Producto" style="max-width: 100px; max-height: 100px;"></img>'
            );
          } else {
            return '<img src="../../public/images/products/defaultprod.png" alt="Slider" style="max-width: 100px; max-height: 100px;"></img>';
          }
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });

  // Manejador de eventos para el botón de editar
  $(document).on("click", ".btnEditar", function () {
    var dataId = $(this).data("id");
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");

    document.getElementById("title").value = "Editar Publicidad";
    document.getElementById("id").value = rowData.id;
    document.getElementById("titulo").value = rowData.titulo;
    document.getElementById("descripcion").value = rowData.descripcion;
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var dataId = $(this).data("id");
    var rowData = miTabla.row($(this).closest("tr")).data();
    // Realizar la solicitud POST al servidor para insertar el nuevo slider

    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteSlider", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salio mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al eliminar slider.");
        }
        
        $("#miModal").modal("hide");
        swal(
          "En Hora Buena!",
          "La accion se realizo de manera exitosa!",
          "success"
        );
        reloadSection();
      })
      .catch((error) => {
        swal(
          "Ups! Algo salio mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
    setLoading(false);
        console.error("Error al insertar el nuevo slider:", error);
      });
  });

  function insertar() {
    try {
      // Obtener los datos del formulario
      const id = document.getElementById("id").value;
      const titulo = document.getElementById("titulo").value;
      const descripcion = document.getElementById("descripcion").value;
      const imagen = document.getElementById("imagen").files[0];

      // Crear un objeto FormData para enviar los datos al servidor
      const formData = new FormData();
      formData.append("titulo", titulo);
      formData.append("descripcion", descripcion);
      formData.append("img", imagen);

      if (id === "") {
        // Realizar la solicitud POST al servidor para insertar el nuevo slider
        fetch("../../controllers/router.php?op=insertSlider", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salio mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error("Hubo un problema al insertar el nuevo slider.");
            }
            
            // Si la inserción fue exitosa, recargar la sección
            $("#miModal").modal("hide");
            swal({
              title: "En Hora Buena!",
              text: "La acción se realizó de manera exitosa!",
              icon: "success",
              timer: 1000,
              buttons: false,
            });
            reloadSection();
          })
          .catch((error) => {
            swal(
              "Ups! Algo salio mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
    setLoading(false);
            console.error("Error al insertar el nuevo slider:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateSlider", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            if (!response.ok) {
              swal(
                "Ups! Algo salio mal!",
                "La acción no se pudo realizar correctamente!",
                "error"
              );
              throw new Error("Hubo un problema al insertar el nuevo slider.");
            }
            
            $("#miModal").modal("hide");
            swal({
              title: "En Hora Buena!",
              text: "La acción se realizó de manera exitosa!",
              icon: "success",
              timer: 1000,
              buttons: false,
            });
            reloadSection();
          })
          .catch((error) => {
            console.error("Error al insertar el nuevo slider:", error);
            swal(
              "Ups! Algo salio mal!",
              "La accion no se pudo realizar correctamente!",
              "error"
            );
          });
      }
    } catch (error) {
      console.error("Error al obtener los datos del formulario:", error);
      swal(
        "Ups! Algo salio mal!",
        "La accion no se pudo realizar correctamente!",
        "error"
      );
    }
  }


  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getAllSliders").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            miTabla.clear().draw();
            miTabla.rows.add(data).draw(); // Aquí se modificó para agregar los datos directamente
          });
        }
      );
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
