document.addEventListener("DOMContentLoaded", async function () {
  timeS = 1000;
  let stockMax = 0;
  let imgProd = "";
  let id_prod = "";
  let stockDisponible = 0;
  const nombreElement = document.getElementById("tv-nombre");
  const precioElement = document.getElementById("tv-precio");
  const inputStock = document.getElementById("input_stock");

  const selectTalla = document.getElementById("id_talla");
  const selectColor = document.getElementById("id_color");

  obtenerIdDelURL();
  reloadSection();
  document
    .getElementById("js-addcart-detail")
    .addEventListener("click", function () {
      const tallaSeleccionada = selectTalla.value;
      const tallaTextoSeleccionado =
        selectTalla.options[selectTalla.selectedIndex].textContent;

      const colorSeleccionado = selectColor.value;
      const colorTextoSeleccionado =
        selectColor.options[selectColor.selectedIndex].textContent;

      try {
        if (tallaSeleccionada === "" || colorSeleccionado === "") {
          throw new Error(
            "Por favor seleccione una talla y un color antes de agregar al carrito."
          );
        }
        if (
          inputStock.value === "" ||
          isNaN(inputStock.value) ||
          inputStock.value < 1
        ) {
          throw new Error(
            "Por favor seleccione una cantidad válida de productos antes de agregar al carrito."
          );
        }

        const cantidadSeleccionada = parseInt(inputStock.value);

        if (cantidadSeleccionada > stockDisponible) {
          throw new Error(
            "La cantidad seleccionada es mayor que el stock disponible."
          );
        }

        const productToAdd = {
          id: Date.now(),
          color: colorTextoSeleccionado,
          color_id: colorSeleccionado,
          talla: tallaTextoSeleccionado,
          talla_id: tallaSeleccionada,
          cantidad: cantidadSeleccionada,
          precio_venta: parseFloat(precioElement.textContent.replace("$", "")),
          img: imgProd,
          producto_id: id_prod,
          nombre: nombreElement.textContent,
        };

        addToCart(productToAdd);
        swal({
          title: nombreElement.textContent,
          text: "Agregado al carrito!",
          icon: "success",
          timer: 1000,
          buttons: false,
        });
      } catch (error) {
        swal("Error", error.message, "warning");
      }
    });
  let tallaSeleccionada = null;
  let colorSeleccionada = null;

  // Llamar a la función selects al cargar la página
  selects();

  function selects() {
    selectTalla.addEventListener("change", () => {
      tallaSeleccionada = selectTalla.value;
      getPrecio(tallaSeleccionada, colorSeleccionada);
      getColores(tallaSeleccionada)
        .then(() => {
          if (
            colorSeleccionada &&
            Array.from(selectColor.options).some(
              (option) => option.value === colorSeleccionada
            )
          ) {
            selectColor.value = colorSeleccionada;
          }
        })
        .catch((error) => {
          console.error("Error obteniendo colores:", error);
        });
    });

    selectColor.addEventListener("change", () => {
      colorSeleccionada = selectColor.value;
      getPrecio(tallaSeleccionada, colorSeleccionada);
      getTallas(colorSeleccionada)
        .then(() => {
          if (
            tallaSeleccionada &&
            Array.from(selectTalla.options).some(
              (option) => option.value === tallaSeleccionada
            )
          ) {
            selectTalla.value = tallaSeleccionada;
          }
        })
        .catch((error) => {
          console.error("Error obteniendo tallas:", error);
        });
    });
  }

  function getColores(talla) {
    return fetch(
      `../../controllers/router.php?op=getColoresTalla&id_prod=${id_prod}&talla=${talla}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los colores disponibles para la talla seleccionada."
          );
        }
        return response.json();
      })
      .then((data) => {
        selectColor.innerHTML = "";
        if (data.length > 0) {
          data.forEach((color) => {
            const option = new Option(color.color, color.id_color);
            selectColor.add(option);
          });
        }
      });
  }

  function getTallas(color) {
    return fetch(
      `../../controllers/router.php?op=getTallasColor&id_prod=${id_prod}&color=${color}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener las tallas disponibles para el color seleccionado."
          );
        }
        return response.json();
      })
      .then((data) => {
        selectTalla.innerHTML = "";
        if (data.length > 0) {
          data.forEach((talla) => {
            const option = new Option(talla.talla, talla.id_talla);
            selectTalla.add(option);
          });
        }
      });
  }

  function getPrecio(talla_id, color_id) {
    const stockSpan = document.getElementById("stock");
    const precioSpan = document.getElementById("tv-precio");
    try {
      fetch(
        "../../controllers/router.php?op=getPrecioShop&prod_id=" +
          id_prod +
          "&talla_id=" +
          talla_id +
          "&color_id=" +
          color_id
      )
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Hubo un problema al obtener los detalles del producto."
            );
          }
          return response.json(); // No es necesario convertir nuevamente a JSON
        })
        .then((productos) => {
          if (productos.length > 0) {
            const producto = productos[0];
            stockSpan.textContent = producto.stock;
            precioSpan.textContent = parseFloat(producto.precio).toFixed(2);
            stockDisponible = producto.stock;
          } else {
            stockSpan.textContent = "No disponible";
            precioSpan.textContent = "No disponible";
            stockDisponible = 0;
          }
        })
        .catch((error) => {
          console.error("Error al obtener los detalles del producto:", error);
          // Si hay un error, mostrar "No disponible"
          stockSpan.textContent = "No disponible";
          precioSpan.textContent = "No disponible";
          stockDisponible = 0;
        });
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
      // Si hay un error, mostrar "No disponible"
      stockSpan.textContent = "No disponible";
      precioSpan.textContent = "No disponible";
      stockDisponible = 0;
    }
  }

  selects();

  document
    .getElementById("id_talla")
    .addEventListener("change", function (event) {
      event.preventDefault();
      const selectTalla = document.getElementById("id_talla");
      const selectedIndex = selectTalla.selectedIndex;
      const selectedOption = selectTalla.options[selectedIndex];
      const selectedValue = selectedOption.value;
      tallaSeleccionada = selectedValue;
    });

  obtenerImagenes();
  metodosPlantilla();

  MetodoControlStock(stockMax);

  function updateStockLabel(stock) {
    const tv_stock = document.getElementById("stock");
    tv_stock.textContent = `${stock}`;
  }

  function MetodoControlStock(stockMax) {
    let stock = 0; // Inicializar la variable stock
    const disminuir = document.getElementById("disminuir");
    const sumar = document.getElementById("sumar");
    const inputStock = document.getElementById("input_stock");

    updateStockLabel(stockMax); // Actualizar la etiqueta inicialmente

    disminuir.addEventListener("click", () => {
      if (stock > 0) {
        stock--;
        inputStock.value = stock;
        updateStockLabel(stockMax); // Siempre actualizar la etiqueta con stockMax al disminuir
      }
    });

    sumar.addEventListener("click", () => {
      if (stock < stockMax) {
        stock++;
        inputStock.value = stock;
        updateStockLabel(stockMax - stock); // Actualizar la etiqueta con el stock disponible restante
      }
    });

    inputStock.addEventListener("change", () => {
      const nuevoValor = parseInt(inputStock.value);
      if (nuevoValor < 0) {
        stock = 0;
      } else if (nuevoValor > stockMax) {
        stock = stockMax;
      } else {
        stock = nuevoValor;
      }
      const availableStock = stockMax - stock;
      inputStock.value = stock; // Actualizar el input con el stock actual
      updateStockLabel(availableStock); // Actualizar la etiqueta con el stock disponible restante
    });
  }

  function obtenerIdDelURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const idParam = urlParams.get("id");
    if (idParam !== null) {
      id_prod = idParam;
    } else {
      console.error("No se encontró el parámetro 'id' en la URL.");
    }
  }

  async function reloadSection() {
    try {
      const nombreElement = document.getElementById("tv-nombre");
      const descripcionElement = document.getElementById("tv-descripcion");

      const response = await fetch(
        "../../controllers/router.php?op=getProductDetail&id=" + id_prod
      );

      if (!response.ok) {
        throw new Error(
          "Hubo un problema al obtener los detalles del producto."
        );
      }

      const producto = await response.json();

      nombreElement.textContent = producto.nombre;
      descripcionElement.textContent = producto.descripcion;
      getTallas(producto.id_color);
      getColores(producto.id_talla);
      getPrecio(producto.id_talla, producto.id_color);
      tallaSeleccionada = producto.id_talla;
      colorSeleccionada = producto.id_color;

      setLoading(false);
    } catch (error) {
      console.error("Error al obtener los detalles del producto:", error);
    }
  }

  async function obtenerImagenes() {
    const galeria = document.getElementById("sliderIMG");
    let html = "";
    await fetch("../../controllers/router.php?op=getAllImgProd&id=" + id_prod)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener las imágenes del producto."
          );
        }
        return response.json();
      })
      .then((data) => {
        if (data.length > 0) {
          data.forEach((imagen, index) => {
            if (imagen.orden === 1) {
              imgProd = imagen.url_imagen;

              html += `<div id="imageContainer" class="border rounded-4 mb-3 d-flex justify-content-center">
              <a data-fslightbox="mygalley" class="rounded-4" data-type="image" href="#">
                <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="${imagen.url_imagen}" />
              </a>
            </div>
            <div class="d-flex justify-content-center mb-3">
            <a data-fslightbox="mygalley" class="border mx-1 rounded-2 item-thumb" data-type="image" href="${imagen.url_imagen}">
            <img width="60" height="60" class="rounded-2" src="${imagen.url_imagen}" />
          </a>`;
            } else {
              html += `
              <a data-fslightbox="mygalley" class="border mx-1 rounded-2 item-thumb" data-type="image"  href="${imagen.url_imagen}">
              <img width="60" height="60" class="rounded-2" src="${imagen.url_imagen}" />
            </a>`;
            }
          });
          html += `</div>`;
          galeria.innerHTML = html;
          // Ahora que las imágenes están en el DOM, agregamos el evento de clic
          agregarEventoClicImagenes();
        } else {
          console.error("No hay imágenes disponibles para este producto");
        }
      })
      .catch((error) => {
        console.error("Error al obtener las imágenes:", error);
      });
  }

  function agregarEventoClicImagenes() {
    // Selecciona todas las imágenes con la clase 'item-thumb'
    var images = document.querySelectorAll(".item-thumb");

    // Agrega un evento de clic a cada imagen
    images.forEach(function (image) {
      image.addEventListener("click", function (event) {
        // Previene el comportamiento predeterminado del enlace
        event.preventDefault();

        // Obtiene la URL de la imagen grande
        var imageURL = this.getAttribute("href");

        // Obtiene el contenedor de imagen
        var imageContainer = document.getElementById("imageContainer");

        // Crea un nuevo elemento de imagen
        var newImage = document.createElement("img");
        newImage.src = imageURL;
        newImage.className = "rounded-4 fit";
        newImage.style.maxWidth = "100%";
        newImage.style.maxHeight = "100vh";
        newImage.style.margin = "auto";

        // Limpia el contenido actual del contenedor de imagen
        imageContainer.innerHTML = "";

        // Agrega la nueva imagen al contenedor
        imageContainer.appendChild(newImage);
      });
    });
  }
});
