document.addEventListener("DOMContentLoaded", async function () {
  metodosModal();
  let productId;
  let entra = true;
  function metodosModal() {
    try {
      const selectProducto = document.getElementById("id_producto");
      selectProducto.addEventListener("change", () => {
        productId = selectProducto.value;
        reloadSection(productId);
      });
      fetch("../../controllers/router.php?op=getProducts")
        .then((response) => {
          if (!response.ok) {
            throw new Error("Hubo un problema al obtener los datos de tallas.");
          }
          return response.json();
        })
        .then((data) => {
          const selectOcasion = document.getElementById("id_producto");
          selectOcasion.innerHTML = "";
          productos = data;
          data.forEach((product) => {
            const option = document.createElement("option");
            option.value = product.id;
            option.textContent = product.nombre + " - " + product.descripcion;
            selectOcasion.appendChild(option);
            if (entra) {
              entra = false;
              productId = product.id;
              reloadSection(productId);
            }
          });
        });
    } catch (error) {
      console.error("Error al obtener los datos:", error);
    }
  }

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
    columns: [
      {
        data: "url_imagen",
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
      { data: "orden", title: "Orden" },
      {
        data: "est",
        title: "Estado",
        render: function (data, type, row) {
          return data == 1
            ? '<button class="badge bg-success border-0 btnEst" data-id="${row.id}">Activado</button>'
            : '<button class="badge bg-danger border-0 btnEst" data-id="${row.id}">Desactivado</button>';
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
    var rowData = miTabla.row($(this).closest("tr")).data();
    $("#miModal").modal("show");
    document.getElementById("title").innerText = "Editar Orden de Imagen";
    $("#id").val(rowData.id);
    $("#orden").val(rowData.orden);
    $("#imagenes").val("");
    // $("#divFile").hide();
  });

  $(document).on("click", ".btnEst", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    fetch("../../controllers/router.php?op=estImgProduct", {
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
          throw new Error("Hubo un problema al cambiar el estado.");
        }

        swal(
          "En Hora Buena!",
          "La accion se realizo de manera exitosa!",
          "success"
        );
        reloadSection(productId);
      })
      .catch((error) => {
        swal(
          "Ups! Algo salio mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al eliminar el Talla:", error);
      });
  });
  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    var formData = new FormData();
    formData.append("id", rowData.id);
    timeS = 3000;
    setLoading(true);
    fetch("../../controllers/router.php?op=deleteImgProduct", {
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
          throw new Error("Hubo un problema al eliminar Talla.");
        }

        $("#miModal").modal("hide");
        swal(
          "En Hora Buena!",
          "La accion se realizo de manera exitosa!",
          "success"
        );
        reloadSection(productId);
      })
      .catch((error) => {
        setLoading(false);
        swal(
          "Ups! Algo salio mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al eliminar el Talla:", error);
      });
  });

  function reloadSection(id) {
    miTabla.clear().draw();
    try {
      fetch("../../controllers/router.php?op=getImagesProducts&id=" + id).then(
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
          setLoading(false);
        }
      );
    } catch (error) {
      setLoading(false);
    }
  }
  reloadSection(null);

  document.getElementById("btnGuardar").addEventListener("click", function () {
    timeS = 20000;    
    setLoading(true);
    insertar();
  });

  function insertar() {
    try {
      const id = document.getElementById("id").value;
      const orden = document.getElementById("orden").value;
      const formData = new FormData();
      formData.append("orden", orden);
      formData.append("id_producto", productId);
      if (id === "") {
        const imagenes = document.getElementById("imagenes").files;
        for (let i = 0; i < imagenes.length; i++) {
          formData.append("imagenes[]", imagenes[i]);
        }
        fetch("../../controllers/router.php?op=insertImgsProduct", {
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
              throw new Error("Hubo un problema al insertar el nuevo Ocasion.");
            }
            document.getElementById("id").value = "";
            document.getElementById("imagenes").value = [];
            document.getElementById("orden").value = "";
            $("#miModal").modal("hide");

            swal({
              title: "En Hora Buena!",
              text: "La acción se realizó de manera exitosa!",
              icon: "success",
              timer: 1000,
              buttons: false,
            });
            reloadSection(productId);
          })
          .catch((error) => {
            setLoading(false);
            swal(
              "Ups! Algo salio mal!",
              "La acción no se pudo realizar correctamente!",
              "error"
            );
            console.error("Error al insertar el nuevo Ocasion:", error);
          });
      } else {
        formData.append("id_img", id);
        fetch("../../controllers/router.php?op=updateImgsProduct", {
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
              throw new Error("Hubo un problema al insertar el nuevo Ocasion.");
            }
            document.getElementById("id").value = "";
            document.getElementById("imagenes").value = [];
            document.getElementById("orden").value = "";
            $("#miModal").modal("hide");
            swal({
              title: "En Hora Buena!",
              text: "La acción se realizó de manera exitosa!",
              icon: "success",
              timer: 1000,
              buttons: false,
            });
            reloadSection(productId);
          })
          .catch((error) => {
            setLoading(false);
            console.error("Error al insertar el nuevo Ocasion:", error);
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
});
