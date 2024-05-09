document.addEventListener("DOMContentLoaded", async function () {
  const totalSpan = document.getElementById("totalspan");
  const subtotalSpan = document.getElementById("subtotal");
  const cenvioSpan = document.getElementById("cenvio");
  metodoProvincias();
  function metodoProvincias() {
    fetch("../../controllers/router.php?op=getProvincias")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectProvincias = document.getElementById("provincias");
        selectProvincias.innerHTML = "";

        data.forEach((provincia) => {
          const option = document.createElement("option");
          option.value = provincia;
          option.textContent = provincia;
          selectProvincias.appendChild(option);
        });
      })
      .catch((error) => {
        console.error("Error al obtener las provincias:", error);
      });
    const selectProducto = document.getElementById("provincias");
    selectProducto.addEventListener("change", () => {
      const productId = selectProducto.value;
      metodoCantones(productId);
    });
  }

  function metodoCantones(productId, canton) {
    fetch("../../controllers/router.php?op=getCantones&provincia=" + productId)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectProvincias = document.getElementById("canton");
        selectProvincias.innerHTML = "";
        data.forEach((provincia) => {
          const option = document.createElement("option");
          option.value = provincia;
          option.textContent = provincia;
          selectProvincias.appendChild(option);
          document.getElementById("canton").value = canton;
        });
      })
      .catch((error) => {
        console.error("Error al obtener las provincias:", error);
      });
  }

  document
    .getElementById("btnpagar")
    .addEventListener("click", async function () {
      event.preventDefault();
      swal({
        title: "¿Esta seguro de realizar la compra?",
        text: "La acción se realizó de manera exitosa!",
        icon: "warning",
        buttons: ["Cancelar", "Confirmar"],
      }).then((confirmado) => {
        if (confirmado) {
          realizarPago();
        }
      });
    });
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
      search: "", // Quitamos el texto "Buscar:"
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
        data: "img",
        title: "Imagen",
        render: function (data, type, row) {
          return `<img src="${data}" alt="imagen del producto" width="50" />`;
        },
      },
      { data: "nombre", title: "Producto" }, // Nombre del producto

      { data: "talla", title: "Talla" },
      { data: "color", title: "Color" },

      { data: "talla_id", title: "Talla", visible: false }, // Talla
      { data: "color_id", title: "Color", visible: false }, // Color
      {
        data: null,
        title: "pedido",
        render: function (data, type, row) {
          return `${row.cantidad} X $${row.precio_venta} = $${
            row["precio_venta"].toFixed(2) * row["cantidad"]
          }`;
        },
      },

      {
        data: null,
        title: "Cantidad",
        render: function (data, type, row) {
          return ` <td class="column-6">
          <div class="wrap-num-product flex-w m-l-auto m-r-0">
              
          <button class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m  btnRestar" data-id="${row.id}">
                  <i class="fs-16 zmdi zmdi-minus"></i>
              </button>
          
              <input id="input_stock_${row.id}" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="${row.cantidad}">
              <button class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m  btnSumar" data-id="${row.id}">
                  <i class="fs-16 zmdi zmdi-plus"></i>
              </button>
          
              </div>
        </td>`;
        },
      },
      {
        data: null,
        title: "Acciones",
        render: function (data, type, row) {
          return `
                    <button type="button" class="btn btn-outline-danger btnEliminar" data-id="${row.id}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></button>`;
        },
      },
    ],
  });
  let SUBTOTAL = 0;
  let CENVIO = 0;
  let TOTAL = 0;
  reloadSection();
  $(document).ready(function () {
    $(".card-header").click(function () {
      // Ocultamos todos los card-body
      $(".card-body").slideUp();
      // Cambiamos el texto de todos los toggleIcon a "+"
      $(".card-header #toggleIcon").text("+");
      var menuBody = $(this).siblings(".card-body");
      if (
        opcion_seleccionada !== "2" ||
        $(this).parent().attr("id") !== "infopago"
      ) {
        menuBody.slideToggle();
      }

      let toggleIcon = $(this).find("#toggleIcon");
      if (
        $(this).parent().attr("id") !== "infopago" &&
        opcion_seleccionada !== "2"
      ) {
        toggleIcon.text(function (i, text) {
          return text === "+" ? "-" : "+";
        });
      }
    });
  });

  let opcion_seleccionada = 1;
  $("#id_envio").change(function () {
    opcion_seleccionada = $(this).val();
    switch (opcion_seleccionada) {
      case "1":
        CENVIO = 5;
        cargarDatosUsuario(false);
        break;
      case "2":
        cargarDatosUsuario(false);
        CENVIO = 0; // Precio para Retiro en oficina
        break;
      case "3":
        cargarDatosUsuario(true);
        CENVIO = 8; // Precio para Enviar regalo
        break;
      default:
        CENVIO = 0;
    }
    reloadSection();
    $("#precio").text(CENVIO.toFixed(2));
  });
  function cargarDatosUsuario(isRegalo) {
    if (isRegalo) {
      document.getElementById("nombre").value = "";
      document.getElementById("provincias").value = "";
      document.getElementById("canton").value = "";
      document.getElementById("direccion").value = "";
      document.getElementById("referencia").value = "";
      document.getElementById("ci").value = "";
      document.getElementById("email").value = "";
      document.getElementById("telefono").value = "";
    } else {
      fetch("../../controllers/router.php?op=getUserData")
        .then((response) => {
          if (response.ok) {
            return response.json(); // Convertir la respuesta a JSON
          }
          throw new Error("Error al obtener los datos del perfil");
        })
        .then((data) => {
          document.getElementById("ci").value = data.cedula;
          document.getElementById("provincias").value = data.provincia;
          document.getElementById("canton").value = data.canton;
          document.getElementById("direccion").value = data.direccion;
          document.getElementById("referencia").value = data.referencia;
          document.getElementById("email").value = data.email;
          document.getElementById("nombre").value = data.nombre;
          metodoCantones(data.provincia, data.canton);
          document.getElementById("telefono").value = data.telefono;
        })
        .catch((error) => {
          console.error("Error:", error);
          // Aquí puedes manejar el error de alguna manera, por ejemplo, mostrando un mensaje al usuario
        });
    }
  }
  function realizarPago() {
    // Obtener el carrito de compras del localStorage
    let carrito = [];
    const carritoJSON = localStorage.getItem("cart");
    if (carritoJSON) {
      carrito = JSON.parse(carritoJSON);
    } else {
      swal("Error", "No existen productos en el carrito", "warning");
      //return;
    }
    const nombre = document.getElementById("nombre").value;
    const provincia = document.getElementById("provincias").value;
    const canton = document.getElementById("canton").value;
    const direccion = document.getElementById("direccion").value;
    const email = document.getElementById("email").value;
    const ci = document.getElementById("ci").value;
    const referencia = document.getElementById("referencia").value;
    const telefono = document.getElementById("telefono").value;
    const metodoDePago = document.getElementById("metododepago").value;
    const comprobante = document.getElementById("comprobante").value;
    const comprobanteInput = document.getElementById("comprobantef");
    const comprobanteFile = comprobanteInput.files[0];
    // Crear un nuevo objeto FormData
    const formData = new FormData();
    formData.append("carrito", JSON.stringify(carrito));
    formData.append("nombre", nombre);
    formData.append("telefono", telefono);
    formData.append("email", email);

    if (opcion_seleccionada === "2") {
      formData.append("direccion", "Barrio “Las Palmas”, calle Ayahuasca");
      formData.append("provincia", "Napo");
      formData.append("canton", "Tena");
      formData.append("referencia", "Oficina Asotaeco");
    } else {
      formData.append("direccion", direccion);
      formData.append("provincia", provincia);
      formData.append("canton", canton);
      formData.append("referencia", referencia);
    }

    formData.append("total", SUBTOTAL);
    formData.append("cenvio", CENVIO);
    formData.append("ci", ci);

    if (opcion_seleccionada === "2") {
      formData.append("isenvio", 0);
      formData.append("metodo_pago", 0);
      formData.append("ncomprobante", "");
      formData.append("comprobante", "");
      enviarDatosAlServidor(formData);
    } else {
      formData.append("isenvio", 1);
      formData.append("metodo_pago", metodoDePago);
      formData.append("ncomprobante", comprobante);
      formData.append("comprobante", comprobanteFile);
      var comprobantef = document.getElementById("comprobantef").files;
      var numeroComprobante = document.getElementById("comprobante").value;
      if (
        CENVIO > 0 &&
        (!comprobantef || comprobantef.length === 0 || !numeroComprobante)
      ) {
        swal("Error", "Por favor complete todos los campos de pago", "warning");
      } else {
        enviarDatosAlServidor(formData);
      }
    }
  }

  async function enviarDatosAlServidor(formData) {
    try {
      timeS = 20000;
      setLoading(true);
      const response = await fetch(
        "../../controllers/router.php?op=insertVentaClient",
        {
          method: "POST",
          body: formData,
        }
      );
      if (response.ok) {
        swal("Excelente!", "Transacción realizada con éxito", "success");
        eliminarProductosLocalStorage();
        reloadSection();
      } else {
        throw new Error("Error en la transacción");
      }
      setLoading(false);
    } catch (error) {
      setLoading(false);
      swal("Error", "Error al enviar los datos: " + error, "warning");
    }
  }

  function reloadSection() {
    try {
      const productos = JSON.parse(localStorage.getItem("cart")) || [];
      miTabla.clear().draw(); // Limpiar la tabla antes de insertar nuevos datos
      SUBTOTAL = 0;

      productos.forEach((producto) => {
        SUBTOTAL +=
          parseFloat(producto.precio_venta) * parseInt(producto.cantidad);
      });
      setLoading(false);
      miTabla.rows.add(productos).draw();
      TOTAL = SUBTOTAL + CENVIO;
      cenvioSpan.textContent = "$" + CENVIO.toFixed(2);
      totalSpan.textContent = "$" + TOTAL.toFixed(2);
      subtotalSpan.textContent = "$" + SUBTOTAL.toFixed(2);
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  $(document).on("click", ".btnEliminar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    cart = cart.filter((producto) => producto.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    reloadCart();
    reloadSection();
  });
  $(document).on("click", ".btnSumar", async function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    let cartString = localStorage.getItem("cart");
    if (!cartString || cartString === "") {
      console.error("El carrito está vacío en el almacenamiento local");
      return;
    }

    let cart = JSON.parse(cartString);
    let producto = cart.find((producto) => producto.id === id);

    if (producto) {
      producto.cantidad = parseInt(producto.cantidad) + 1;

      const stockActual = await getPrecioShop(
        producto.producto_id,
        producto.talla_id,
        producto.color_id
      );
      if (stockActual > producto.cantidad) {
        localStorage.setItem("cart", JSON.stringify(cart));
        reloadCart();
        reloadSection();
      } else {
        producto.cantidad = stockActual;
        localStorage.setItem("cart", JSON.stringify(cart));
        reloadCart();
        reloadSection();
      }
    }
  });

  $(document).on("click", ".btnRestar", function () {
    var id = $(this).data("id");
    let cart = JSON.parse(localStorage.getItem("cart"));
    let producto = cart.find((producto) => producto.id === id);
    if (producto) {
      const cantidad = producto.cantidad--;
      if (cantidad < 2) {
        producto.cantidad = 1;
      }
      localStorage.setItem("cart", JSON.stringify(cart));
      reloadCart();
      reloadSection();
    }
  });

  async function getPrecioShop(prod_id, talla_id, color_id) {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getPrecioShop&prod_id=" +
          prod_id +
          "&talla_id=" +
          talla_id +
          "&color_id=" +
          color_id
      );
      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }

      const productos = await response.json(); // Esperar la resolución de la promesa
      if (productos.length > 0) {
        const producto = productos[0];
        return producto.stock;
      } else {
        return 0;
      }
    } catch (error) {
      swal(
        "Ups! Algo salió mal!",
        "La acción no se pudo realizar correctamente! " + error,
        "error"
      );
      return 0;
    }
  }
});
function eliminarProductosLocalStorage() {
  localStorage.removeItem("cart");
  location.reload();
}
function toggleFields() {
  var paymentMethod = document.getElementById("metododepago").value;
  var paymentFields = document.getElementById("camposPago");

  if (paymentMethod === "0") {
    // Pago en oficina selected, hide fields
    paymentFields.style.display = "none";
  } else {
    // Deposito or Transferencia selected, show fields
    paymentFields.style.display = "block";
  }
}

// Initialize the fields based on the initial selected option
toggleFields();
