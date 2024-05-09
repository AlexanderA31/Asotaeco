document.addEventListener("DOMContentLoaded", async function () {
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
      { data: "nombre", title: "Nombre" },
      { data: "email", title: "Email" },
      { data: "telefono", title: "Teléfono" },
      {
        data: "rol_id",
        title: "Rol",
        render: function (data, type, row) {
          return data == 1 ? "Administrador" : "Cliente";
        },
      },
      {
        data: "est",
        title: "Estado",
        render: function (data, type, row) {
          return data == 1
            ? '<button class="badge bg-success border-0 btnEliminar" data-id="${row.id}">Activado</button>'
            : '<button class="badge bg-danger border-0 btnEliminar" data-id="${row.id}">Desactivado</button>';
        },
      },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `<button type="button" class="btn btn-outline-warning btnEditar" data-id="${row.id}">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
  timeS = 2000;
  // Manejador de eventos para el botón de editar
  $(document).on("click", ".btnEditar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    document.getElementById("title").value = "Editar Usuario";
    $("#id").val(rowData.id);
    $("#email").val(rowData.email);
    $("#nombre").val(rowData.nombre);
    $("#direccion").val(rowData.direccion);
    $("#cedula").val(rowData.cedula);
    $("#rol_id").val(rowData.rol_id);
  });

  // Manejador de eventos para el botón de eliminar
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    setLoading(true);
    fetch("../../controllers/router.php?op=deleteUser", {
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
          throw new Error("Hubo un problema al eliminar User.");
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
        console.error("Error al insertar el nuevo User:", error);
      });
  });
  document.getElementById("btnGuardar").addEventListener("click", function () {
    insertar(); // Llama a la función insertSlider cuando se hace clic en el botón
  });
  function insertar() {
    try {
      // Obtener los datos del formulario del modal
      const id = document.getElementById("id").value;
      const email = document.getElementById("email").value;
      const nombre = document.getElementById("nombre").value;
      const direccion = document.getElementById("direccion").value;
      const cedula = document.getElementById("cedula").value;
      const rol_id = document.getElementById("rol_id").value;
      const telefono = document.getElementById("telefono").value;
      const formData = new FormData();

      formData.append("email", email);
      formData.append("nombre", nombre);
      formData.append("direccion", direccion);
      formData.append("cedula", cedula);
      formData.append("telefono", telefono);
      formData.append("rol_id", rol_id);
      setLoading(true);
      if (id === "") {
        formData.append("pass", cedula);
        fetch("../../controllers/router.php?op=registro", {
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
              throw new Error("Hubo un problema al insertar el nuevo User.");
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
            console.error("Error al insertar el nuevo User:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateUser", {
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
              throw new Error("Hubo un problema al insertar el nuevo User.");
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
            setLoading(false);
            console.error("Error al insertar el nuevo User:", error);
            swal(
              "Ups! Algo salio mal!",
              "La accion no se pudo realizar correctamente!",
              "error"
            );
          });
      }
    } catch (error) {
      setLoading(false);
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
      fetch("../../controllers/router.php?op=getAllEmpresa").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            // Limpiar los datos existentes en la tabla
            miTabla.clear().draw();
            // Agregar los nuevos datos a la tabla
            miTabla.rows.add(data).draw();
            setLoading(false);
          });
        }
      );
    } catch (error) {
      setLoading(false);
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
