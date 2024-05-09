document.addEventListener("DOMContentLoaded", function () {
  getSliders();
  timeS = 5000;
  async function getSliders() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getSliders"
      );
      const data = await response.json();

      // Obtener el contenedor del slider y los indicadores
      const sliderContainer = document.getElementById("sliderContainer");
      const sliderIndicators = document.getElementById("sliderIndicators");
      const carouselInner = document.querySelector(".carousel-inner");

      // Limpiar el contenido del contenedor del slider y los indicadores
      sliderIndicators.innerHTML = "";
      carouselInner.innerHTML = "";

      data.forEach((slider, index) => {
        const imagen = slider.img
          ? slider.img
          : "../../public/images/sliders/defaultslider.jpg";
        const url = slider.url_web ? slider.url_web : "#";
        const slideItem = document.createElement("div");
        slideItem.classList.add("carousel-item");
        if (index === 0) {
          slideItem.classList.add("active");
        }
        const slideContent = `
        <div class="carousel-caption d-none d-md-block text-left align-items-center text-white" style="background-color:rgba(0, 133, 64, 0.101);">
        <h5 class="card-title display-2">${slider.titulo}</h5>

            <p class="card-text display-6">${slider.descripcion}</p>
        </div>
        <img src="${imagen}" class="d-block w-100" alt="${slider.titulo}">
    `;
        slideItem.innerHTML = slideContent;
        carouselInner.appendChild(slideItem);
        const indicator = document.createElement("li");
        indicator.setAttribute("data-target", "#sliderContainer");
        indicator.setAttribute("data-slide-to", index);
        if (index === 0) {
          indicator.classList.add("active");
        }
        sliderIndicators.appendChild(indicator);
      });

      // Agregar los botones de control al contenedor del slider
      const controlsHTML = `
    <a class="carousel-control-prev" href="#sliderContainer" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>
		<a class="carousel-control-next" href="#sliderContainer" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Siguiente</span>
		</a>

      `;
      sliderContainer.innerHTML += controlsHTML;

      // Inicializar el componente del slider de Bootstrap
      $(".carousel").carousel();
    } catch (error) {
      console.error("Error al obtener sliders:", error);
    }
  }
  reloadSection();
  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsRecent"
      );
      const data = await response.json();
      const productGrid = document.getElementById("productGrid");
      productGrid.innerHTML = ""; // Limpiamos el contenido existente
      data.forEach((producto) => {
        const imagenProducto1 = producto.imagen1
          ? producto.imagen1
          : "../../public/images/products/defaultprod.png";
        const imagenProducto2 = producto.imagen2
          ? producto.imagen2
          : "../../public/images/products/defaultprod.png";
        const productoDiv = document.createElement("div");
        productoDiv.classList.add(
          "col-lg-3",
          "col-md-4",
          "col-sm-6",
          "mb-4",
          "product-grid"
        );
        productoDiv.innerHTML = `
          <div class="card h-100">
            <div class="product-image">
              <a href="../product-detail/index.php?id=${producto.id_producto}" class="image">
                <img class="card-img-top img-1" src="${imagenProducto1}" alt="Product Image">
                <img class="card-img-top img-2" src="${imagenProducto2}" alt="Product Image">
              </a>
              <span class="product-hot-label">${producto.ocasion}</span>
              <ul class="product-links">

                <li>
                <button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 btnAddWish"  data-id="${producto.id_producto}">
                <a ><i class="fa fa-heart"></i></a>
                </button>
                </li>
               
              </ul>
              <a href="../product-detail/index.php?id=${producto.id_producto}" class="product-view"><i class="fa fa-search"></i></a>
            </div>
            <div class="card-body">
            <a href="../product-detail/index.php?id=${producto.id_producto}" class="card-titles text-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text-decoration-none"> <h4>${producto.nombre}</h4>
            </a>
            <div class="rating">
              <span class="enable">Tallas: </span>
                <span class="disable">${producto.tallas}</span>
              </div>
              <h5>$${producto.precio}</h5>
            </div>
          </div>
        `;
        productGrid.appendChild(productoDiv);
      });
      setLoading(false);
    } catch (error) {
      setLoading(false);
      console.error("Error al obtener productos:", error);
    }
  }

  $(document).on("click", ".btnAddWish", function () {
    var id = $(this).data("id");
    const formData = new FormData();
    formData.append("id_producto", id);
    fetch("../../controllers/router.php?op=insertWishClient", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        
        if (response.ok) {
          swal("Excelente!", "Producto agregado a favoritos", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });
});
