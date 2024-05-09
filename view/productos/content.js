document.addEventListener("DOMContentLoaded", async function () {
  document.getElementById("btnGuardar").addEventListener("click", function () {
    setLoading(true);
    insertar(); // Llama a la función insertar cuando se hace clic en el botón
  });

  metodosModal();
  function metodosModal() {
    try {
      fetch("../../controllers/router.php?op=getOcasion")
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los datos de ocasión."
            );
          }
          return response.json();
        })
        .then((data) => {
          const selectOcasion = document.getElementById("id_ocasion");
          selectOcasion.innerHTML = "";
          data.forEach((ocasion) => {
            const option = document.createElement("option");
            option.value = ocasion.id;
            option.textContent = ocasion.nombre;
            selectOcasion.appendChild(option);
          });
        });

      fetch("../../controllers/router.php?op=getTipoPrenda")
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los datos de tipo de prenda."
            );
          }
          return response.json();
        })
        .then((data) => {
          const selectTipoPrenda = document.getElementById("id_tipo_prenda");
          selectTipoPrenda.innerHTML = "";
          data.forEach((tipoPrenda) => {
            const option = document.createElement("option");
            option.value = tipoPrenda.id;
            option.textContent = tipoPrenda.nombre;
            selectTipoPrenda.appendChild(option);
          });
        });

      fetch("../../controllers/router.php?op=getGenero")
        .then((response) => {
          if (!response.ok) {
            throw new Error("Hubo un problema al obtener los datos de género.");
          }
          return response.json();
        })
        .then((data) => {
          const selectGenero = document.getElementById("id_genero");
          selectGenero.innerHTML = "";
          data.forEach((genero) => {
            const option = document.createElement("option");
            option.value = genero.id;
            option.textContent = genero.nombre;
            selectGenero.appendChild(option);
          });
        });
    } catch (error) {
      console.error("Error al obtener los datos:", error);
    }
  }

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
      { data: "nombre", title: "Nombre" }, // Nombre
      { data: "descripcion", title: "Descripción" }, // Descripción
      {
        data: "imagen",
        title: "Imagen",
        render: function (data, type, row) {
          if (data) {
            return (
              '<img src="' +
              data +
              '" alt="Producto" style="max-width: 100px; max-height: 100px;">'
            );
          } else {
            return '<img src="../../public/images/products/defaultprod.png" alt="Producto por defecto" style="max-width: 100px; max-height: 100px;">';
          }
        },
      },
      { data: "genero", title: "Genero" }, // Talla
      { data: "ocasion", title: "Ocasión" },
      { data: "tipo_prenda", title: "Tipo de Prenda" },
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
  // Manejador de eventos para el botón de editar
  $(document).on("click", ".btnEditar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    document.getElementById("descripcion").value = rowData.descripcion;
    document.getElementById("nombre").value = rowData.nombre;
    document.getElementById("title").innerHTML = "Editar Productos";
    document.getElementById("id").value = rowData.id;
    document.getElementById("est").value = rowData.est;
    document.getElementById("id_tipo_prenda").value = rowData.id_tipo_prenda;
    document.getElementById("id_genero").value = rowData.id_genero;
    document.getElementById("id_ocasion").value = rowData.id_ocasion;
  });

  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();

    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=deleteProduct", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al eliminar el producto.");
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
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al eliminar el producto:", error);
      });
  });

  function insertar() {
    try {
      const id = document.getElementById("id").value;
      const nombre = document.getElementById("nombre").value;
      const descripcion = document.getElementById("descripcion").value;
      const imagenes = document.getElementById("imagenes").files;
      const genero = document.getElementById("id_genero").value;
      const tipoPrenda = document.getElementById("id_tipo_prenda").value;
      const ocasion = document.getElementById("id_ocasion").value;
      const est = document.getElementById("est").value;
      const formData = new FormData();
      formData.append("nombre", nombre);
      formData.append("descripcion", descripcion);
      for (let i = 0; i < imagenes.length; i++) {
        formData.append("imagenes[]", imagenes[i]);
      }
      formData.append("est", est);
      formData.append("id_genero", genero);
      formData.append("id_tipo_prenda", tipoPrenda);
      formData.append("id_ocasion", ocasion);

      if (id === "") {
        fetch("../../controllers/router.php?op=insertProduct", {
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
              throw new Error(
                "Hubo un problema al insertar el nuevo Ocasion."
              );
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
            console.error("Error al insertar el nuevo Product:", error);
          });
      } else {
        formData.append("id", id);
        fetch("../../controllers/router.php?op=updateProduct", {
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
              throw new Error(
                "Hubo un problema al insertar el nuevo Product."
              );
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
            console.error("Error al insertar el nuevo Product:", error);
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
        "Ups! Algo salió mal!",
        "La acción no se pudo realizar correctamente!",
        "error"
      );
    }
  }

  function reloadSection() {
    try {
      fetch("../../controllers/router.php?op=getAllProducts").then(
        (response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          response.json().then((data) => {
            miTabla.clear().draw();
            miTabla.rows.add(data).draw(); // Agregar los datos directamente
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
