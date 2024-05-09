document.addEventListener("DOMContentLoaded", async function () {
  const btnPagar = document.getElementById("btnPagar");
  const btnAdd = document.getElementById("btnAdd");

  let id_producto = document.getElementById("id_producto").value;
  let id_proveedor = document.getElementById("id_proveedor").value;
  let costo = document.getElementById("costo").value;
  let stock = document.getElementById("stock").value;
  let precio = document.getElementById("precio").value;
  let id_color = document.getElementById("id_color").value;
  let id_talla = document.getElementById("id_talla").value;
  const idInput = document.getElementById("id_hidden");
  btnAdd.addEventListener("click", function () {
    id_producto = document.getElementById("id_producto").value;
    id_proveedor = document.getElementById("id_proveedor").value;
    costo = document.getElementById("costo").value;
    stock = document.getElementById("stock").value;
    precio = document.getElementById("precio").value;
    id_color = document.getElementById("id_color").value;
    id_talla = document.getElementById("id_talla").value;
    id = idInput.value;

    if (
      id_producto.trim() !== "" &&
      id_proveedor.trim() !== "" &&
      costo.trim() !== "" &&
      stock.trim() !== "" &&
      precio.trim() !== "" &&
      id_color.trim() !== "" &&
      id_talla.trim() !== ""
    ) {
      setLoading(true);
      if (id === "") {
        insertProduct();
      } else {
        updateProduct();
      }
    } else {
      swal(
        "Ups! Algo salió mal!",
        "Por favor, complete todos los campos.",
        "error"
      );
    }
  });
  let entra = 0;
  function insertProduct() {
    entra++;
    const nombre_producto =
      document.getElementById("id_producto").options[
        document.getElementById("id_producto").selectedIndex
      ].text;
    const nombre_proveedor =
      document.getElementById("id_proveedor").options[
        document.getElementById("id_proveedor").selectedIndex
      ].text;
    const nombre_color =
      document.getElementById("id_color").options[
        document.getElementById("id_color").selectedIndex
      ].text;
    const nombre_talla =
      document.getElementById("id_talla").options[
        document.getElementById("id_talla").selectedIndex
      ].text;
    const producto = {
      id: Date.now(),
      id_producto: id_producto,
      nombre_producto: nombre_producto,
      id_proveedor: id_proveedor,
      nombre_proveedor: nombre_proveedor,
      costo: costo,
      stock: stock,
      precio: precio,
      id_color: id_color,
      nombre_color: nombre_color,
      id_talla: id_talla,
      nombre_talla: nombre_talla,
    };
    let productosGuardados =
      JSON.parse(localStorage.getItem("productos")) || [];

    btnAdd.disabled = true;

    swal({
      title: "En Hora Buena!",
      text: "La acción se realizó de manera exitosa!",
      icon: "success",
      timer: 1000,
      buttons: false,
    });
    productosGuardados.push(producto);
    localStorage.setItem("productos", JSON.stringify(productosGuardados));
    reloadSection();
    return;
  }
  function updateProduct() {
    const nombre_producto =
      document.getElementById("id_producto").options[
        document.getElementById("id_producto").selectedIndex
      ].text;
    const nombre_proveedor =
      document.getElementById("id_proveedor").options[
        document.getElementById("id_proveedor").selectedIndex
      ].text;
    const nombre_color =
      document.getElementById("id_color").options[
        document.getElementById("id_color").selectedIndex
      ].text;
    const nombre_talla =
      document.getElementById("id_talla").options[
        document.getElementById("id_talla").selectedIndex
      ].text;
    const productosGuardados =
      JSON.parse(localStorage.getItem("productos")) || [];
    const index = productosGuardados.findIndex(
      (producto) => producto.id.toString() === id.toString()
    );

    if (index !== -1) {
      productosGuardados[index] = {
        id: id_producto,
        nombre_producto: nombre_producto,
        id_proveedor: id_proveedor,
        nombre_proveedor: nombre_proveedor,
        costo: costo,
        stock: stock,
        precio: precio,
        id_color: id_color,
        nombre_color: nombre_color,
        id_talla: id_talla,
        nombre_talla: nombre_talla,
      };

      localStorage.setItem("productos", JSON.stringify(productosGuardados));
      document.getElementById("id_hidden").value = "";
      swal({
        title: "En Hora Buena!",
        text: "La acción se realizó de manera exitosa!",
        icon: "success",
        timer: 1000,
        buttons: false,
      });
      clearFormFields();
      reloadSection();
    }
  }
  btnPagar.addEventListener("click", function () {
    const productos = JSON.parse(localStorage.getItem("productos")) || [];
    let productoInvalidoEncontrado = false;
    const productosPorProveedor = {};
    productos.forEach((producto) => {
      if (
        parseInt(producto.stock) === 0 ||
        parseFloat(producto.costo) === 0 ||
        parseFloat(producto.precio) === 0
      ) {
        productoInvalidoEncontrado = true;
        return; // Sale del forEach si encuentra un producto inválido
      }

      if (!productosPorProveedor[producto.id_proveedor]) {
        productosPorProveedor[producto.id_proveedor] = {
          productos: [],
          totalCompra: 0,
        };
      }
      const costoProducto = parseFloat(producto.costo);
      const stockProducto = parseInt(producto.stock);
      const totalProducto = costoProducto * stockProducto;
      productosPorProveedor[producto.id_proveedor].productos.push(producto);
      productosPorProveedor[producto.id_proveedor].totalCompra += totalProducto;
    });

    if (productoInvalidoEncontrado) {
      reloadSection();
      swal(
        "Alerta",
        "Existe al menos un producto con stock, precio o costo igual a cero.",
        "warning"
      );
      return;
    }

    productos.forEach((producto) => {
      if (!productosPorProveedor[producto.id_proveedor]) {
        productosPorProveedor[producto.id_proveedor] = {
          productos: [],
          totalCompra: 0,
        };
      }
      const costoProducto = parseFloat(producto.costo);
      const stockProducto = parseInt(producto.stock);
      const totalProducto = costoProducto * stockProducto;
      productosPorProveedor[producto.id_proveedor].productos.push(producto);
      productosPorProveedor[producto.id_proveedor].totalCompra += totalProducto;
    });

    const promises = [];

    for (const id_proveedor in productosPorProveedor) {
      const productosProveedor = productosPorProveedor[id_proveedor].productos;
      const totalCompraProveedor =
        productosPorProveedor[id_proveedor].totalCompra;
      productosProveedor.forEach((producto) => {
        producto.total = totalCompraProveedor;
      });

      promises.push(enviarProductosAlServidor(productosProveedor));
    }

    Promise.all(promises)
      .then(() => {
        eliminarProductosLocalStorage();
        swal({
          title: "En Hora Buena!",
          text: "La acción se realizó de manera exitosa!",
          icon: "success",
          timer: 1000,
          buttons: false,
        });
      })
      .catch((error) => {
        swal(
          "Ups! Algo salió mal!",
          "La acción no se pudo realizar correctamente!",
          "error"
        );
        //console.error("Error al insertar los productos:", error);
      });
  });

  function enviarProductosAlServidor(productos) {
    return new Promise((resolve, reject) => {
      try {
        const formData = new FormData();
        formData.append("productos", JSON.stringify(productos));
        fetch("../../controllers/router.php?op=insertCompra", {
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
              throw new Error("Hubo un problema al insertar los productos.");
            }

            resolve();
          })
          .catch((error) => {
            reject(error);
          });
      } catch (error) {
        reject(error);
      }
    });
  }

  function eliminarProductosLocalStorage() {
    localStorage.removeItem("productos");
    reloadSection();
  }

  function clearFormFields() {
    document.getElementById("id_hidden").value = "";
    document.getElementById("id_producto").value = "Seleccione...";
    document.getElementById("id_proveedor").value = "Seleccione...";
    document.getElementById("costo").value = "";
    document.getElementById("stock").value = "";
    document.getElementById("precio").value = "";
    document.getElementById("id_color").value = "Seleccione...";
    document.getElementById("id_talla").value = "Seleccione...";
  }

  metodosModal();
  const imgProd = document.getElementById("imgProd");
  const selectProducto = document.getElementById("id_producto");
  selectProducto.addEventListener("change", () => {
    const productId = selectProducto.value;
    const selectedProduct = productos.find(
      (product) => product.id == productId
    );
    if (selectedProduct) {
      imgProd.src = selectedProduct.imagen;
      if (selectedProduct.imagen == null) {
        imgProd.src = "../../public/images/products/defaultprod.png";
      }
    }
  });

  let productos;
  function metodosModal() {
    fetch("../../controllers/router.php?op=getProducts")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectOcasion = document.getElementById("id_producto");
        imgProd.src = data[0].imagen;
        selectOcasion.innerHTML = "";
        productos = data;
        data.forEach((product) => {
          const option = document.createElement("option");
          option.value = product.id;
          option.textContent = product.nombre + " - " + product.descripcion;
          selectOcasion.appendChild(option);
        });
      });
    fetch("../../controllers/router.php?op=getTallas")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de tallas.");
        }
        return response.json();
      })
      .then((data) => {
        const selectOcasion = document.getElementById("id_talla");
        selectOcasion.innerHTML = "";
        data.forEach((talla) => {
          const option = document.createElement("option");
          option.value = talla.id;
          option.textContent = talla.talla;
          selectOcasion.appendChild(option);
        });
      });

    fetch("../../controllers/router.php?op=getColores")
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los datos de tipo de prenda."
          );
        }
        return response.json();
      })
      .then((data) => {
        const selectTipoPrenda = document.getElementById("id_color");
        selectTipoPrenda.innerHTML = "";
        data.forEach((color) => {
          const option = document.createElement("option");
          option.value = color.id;
          option.textContent = color.color;
          selectTipoPrenda.appendChild(option);
        });
      });

    fetch("../../controllers/router.php?op=getProveedores")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Hubo un problema al obtener los datos de género.");
        }
        return response.json();
      })
      .then((data) => {
        const selectGenero = document.getElementById("id_proveedor");
        selectGenero.innerHTML = "";
        data.forEach((proveedor) => {
          const option = document.createElement("option");
          option.value = proveedor.id;
          option.textContent = proveedor.nombre;
          selectGenero.appendChild(option);
        });
      });
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
      { data: "nombre_producto", title: "Producto" }, // Nombre del producto

      { data: "stock", title: "Cantidad" },
      { data: "costo", title: "Costo" },
      {
        title: "Sub Total",
        render: function (data, type, row) {
          // Calcular el subtotal multiplicando cantidad por costo
          var subtotal = parseInt(row.stock) * parseFloat(row.costo);
          return subtotal.toFixed(2); // Formatear el subtotal con dos decimales
        },
      },
      { data: "nombre_talla", title: "Talla" }, // Talla
      { data: "nombre_color", title: "Color" }, // Color
      { data: "nombre_proveedor", title: "Proveedor" },
      {
        data: null,
        title: "Acciones",
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

    // Asignar valores de la fila seleccionada al formulario de inserción

    document.getElementById("id_hidden").value = rowData.id;
    document.getElementById("id_producto").value = rowData.id_producto;
    document.getElementById("id_proveedor").value = rowData.id_proveedor;
    document.getElementById("costo").value = rowData.costo;
    document.getElementById("stock").value = rowData.stock;
    document.getElementById("precio").value = rowData.precio;
    document.getElementById("id_color").value = rowData.id_color;
    document.getElementById("id_talla").value = rowData.id_talla;

    // Mostrar la imagen del producto
    var imgProd = document.getElementById("imgProd");
    if (rowData.imagen) {
      imgProd.src = rowData.imagen;
    } else {
      imgProd.src = "../../public/images/products/defaultprod.png";
    }
    $("#miModal").modal("show");
  });

  $(document).on("click", ".btnEliminar", function () {
    var rowData = miTabla.row($(this).closest("tr")).data();
    try {
      let productosGuardados =
        JSON.parse(localStorage.getItem("productos")) || [];
      productosGuardados = productosGuardados.filter(
        (producto) => producto.id !== rowData.id
      );
      swal({
        title: "En Hora Buena!",
        text: "La acción se realizó de manera exitosa!",
        icon: "success",
        timer: 1000,
        buttons: false,
      });
      localStorage.setItem("productos", JSON.stringify(productosGuardados));
      reloadSection();
    } catch (error) {
      swal(
        "Ups! Algo salió mal!",
        "La acción no se pudo realizar correctamente!" + error,
        "error"
      );
    }
  });

  function reloadSection() {
    btnPagar.disabled = true;
    try {
      const productos = JSON.parse(localStorage.getItem("productos")) || [];
      miTabla.clear().draw();
      let total = 0;

      productos.forEach((producto) => {
        total += parseFloat(producto.precio) * parseInt(producto.stock);
      });
      if (total > 0) {
        btnPagar.disabled = false;
      }
      document.getElementById("btnAdd").disabled = false;
      document.getElementById("total").textContent = total.toFixed(2);
      miTabla.rows.add(productos).draw();
      setLoading(false);
    } catch (error) {
      setLoading(false);
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  // Cargar los datos al cargar la página
  reloadSection();
});
