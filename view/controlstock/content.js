document.addEventListener("DOMContentLoaded", async function () {
  metodosModal();
  document.getElementById("btnDPDF").addEventListener("click", function () {
    const selectProducto = document.getElementById("id_producto");
    const productId = selectProducto.value;
    fetch("../../controllers/router.php?op=downloadStock&id=" + productId, {
      method: "GET",
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salió mal!",
            "La acción no se pudo realizar correctamente!",
            "error"
          );
          throw new Error("Hubo un problema al obtener el PDF.");
        }
        return response.blob(); // Convertir la respuesta en un blob
      })
      .then((blob) => {
        const url = window.URL.createObjectURL(blob);
        const currentDate = new Date();
        const formattedDate = currentDate
          .toISOString()
          .slice(0, 19)
          .replace(/[-T]/g, "")
          .replace(":", "")
          .replace(":", "");
        const fileName = `ventas_${formattedDate}.pdf`;
        const a = document.createElement("a");
        a.href = url;
        a.download = fileName;
        a.click();
        swal({
          title: "¡En Hora Buena!",
          text: "¡La acción se realizó de manera exitosa!",
          icon: "success",
          timer: 1000, // tiempo en milisegundos
          buttons: false, // ocultar botones
        });
        reloadSection();
      })
      .catch((error) => {
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        console.error("Error al obtener el PDF:", error);
      });
  });
  let id1 = 0;
  let entra = true;
  function metodosModal() {
    try {
      const selectProducto = document.getElementById("id_producto");
      selectProducto.addEventListener("change", () => {
        const productId = selectProducto.value;
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
              id1 = product.id;
              reloadSection(id1);
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
    dom: "Bfrtip", // Agregar los botones de descarga
    buttons: [
      "copyHtml5", // Botón de copiar
      "excelHtml5", // Botón de Excel
      "csvHtml5", // Botón de CSV
      "pdfHtml5", // Botón de PDF
    ],
    lengthChange: false,
    columns: [
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
      { data: "descripcion", title: "Descripción" },
      { data: "talla", title: "Talla" },
      { data: "ocasion", title: "Ocasión" },
      { data: "color", title: "Color" },
      { data: "genero", title: "Género" },
      { data: "stock_total", title: "Stock" },
      {
        data: "precio_promedio",
        title: "Precio",
        render: function (data, type, row) {
          return "$" + parseFloat(data).toFixed(2);
        },
      },
    ],
  });

  function reloadSection(id) {
    miTabla.clear().draw();
    try {
      fetch(
        "../../controllers/router.php?op=getAllProductsStock&id=" + id
      ).then((response) => {
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
      });
    } catch (error) {
      setLoading(false);
    }
  }
  reloadSection(null);
});
