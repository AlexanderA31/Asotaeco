document.addEventListener("DOMContentLoaded", async function () {
  reloadSection();

  var url = window.location.href;
  var urlParams = new URLSearchParams(new URL(url).search);
  var filterValue = urlParams.has("filter") ? urlParams.get("filter") : null;

  let currentPage = 1;
  const itemsPerPage = 16;
  let data;
  async function reloadSection() {
    try {
      const response = await fetch(
        "../../controllers/router.php?op=getProductsShop"
      );
      data = await response.json();

      if (filterValue !== null) {
        filtrarPorGenero(filterValue);
      } else {
        mostrarElementosEnBloques(data);
      }
      setLoading(false);
    } catch (error) {
      console.error("Error al obtener productos:", error);
    }
  }

  function mostrarElementosEnBloques(dataFilter) {
    const container = document.getElementById("container");
    //container.style.minHeight = "150vh";
    container.innerHTML = "";

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentData = dataFilter.slice(startIndex, endIndex);

    if (currentData && currentData.length > 0) {
      currentData.forEach((producto) => {
        const imagenProducto = producto.imagen
          ? producto.imagen
          : "../../public/images/products/defaultprod.png";
        const productoHTML = `
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ${producto.genero}">
          <div class="block2">
            <div class="block2-pic hov-img0">
              <img src="${imagenProducto}" alt="Product Image">
              <a href="../product-detail/index.php?id=${producto.id_producto}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-modal1 text-decoration-none">Ver Producto</a>
            </div>
            <div class="block2-txt flex-w flex-t p-t-14">
              <div class="block2-txt-child1 flex-col-l">
                <a href="../product-detail/index.php?id=${producto.id_producto}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text-decoration-none">${producto.nombre}</a>
                <span class="stext-105 cl3">$${producto.precio}</span>
              </div>
              <div class="block2-txt-child2 flex-r p-t-3">
                <button class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 btnAddWish"  data-id="${producto.id_producto}">
                  <img class="icon-heart1 dis-block trans-04" src="../../public/images/icons/icon-heart-01.png" alt="Heart Icon">
                  <img class="icon-heart2 dis-block trans-04 ab-t-l" src="../../public/images/icons/icon-heart-02.png" alt="Heart Icon">
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
        container.innerHTML += productoHTML;
      });
      //MostrarFooter();

      renderPagination(dataFilter.length); // Mantenemos la paginación basada en la longitud total de los datos, no solo en los datos mostrados
    } else {
      container.innerHTML = "";
      const liVacio = document.createElement("div");
      liVacio.textContent = "No existen elementos";
      container.appendChild(liVacio);
    }
  }

  function renderPagination(totalItems) {
    const pages = Math.ceil(totalItems / itemsPerPage);
    const pagination = document.querySelector(".pagination");
    pagination.innerHTML = "";

    for (let i = 1; i <= pages; i++) {
      const li = document.createElement("li");
      li.classList.add("page-item");
      const a = document.createElement("a");
      a.classList.add("page-link");
      a.href = "#";
      a.textContent = i;
      a.addEventListener("click", () => {
        if (pages > 1) {
          currentPage = i;
          mostrarElementosEnBloques(data);
        }
      });
      li.appendChild(a);
      pagination.appendChild(li);
    }
  }

  function MostrarFooter() {
    const footer = document.getElementById("footer");
    footer.innerHTML = "";
    footer.innerHTML = `
    <footer class="footer bg-dark text-white py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h4>Asotaeco</h4>
        <a href="../infoempresa/informacion.php">
          <span>
            Quiénes somos
          </span>
        </a>
      </div>
      <div class="col-md-4">
        <h4>Contacto</h4>
        <p><i class="fa fa-phone" aria-hidden="true"></i> Call +593 99 523 6593</p>
        <p><i class="fa fa-envelope" aria-hidden="true"></i> asotaec@hotmail.com</p>
        <div class="footer_social">
          <a href="https://www.facebook.com/margoty1987" target="_blank" class="text-white">
            <i class="fa fa-facebook"></i> Facebook
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col">
            <h4>Horario de Atención</h4>
            <p>Lunes - Viernes<br>7.00 am - 6.00 pm</p>
          </div>
          <div class="col">
            <h4>Ubicación</h4>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> Barrio “Las Palmas”, calle Ayahuasca</p>
          </div>
        </div>
        <!-- Mapa -->
        <div class="map-responsive mt-3">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2313560558673!2d-77.81956842526523!3d-0.9828160353692498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d6a5fdca06774d%3A0x5dbc3647ff4e1453!2sAsociaci%C3%B3n%20%22Asotaeco%22!5e0!3m2!1ses!2sec!4v1706770322235!5m2!1ses!2sec" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>
  <div class="container text-center mt-4">
    <div class="row">
      <div class="col">
        <div class="reglamento">
          <a href="ESTATUTO.pdf" download="Estatuto.pdf" class="text-white">
            <i class="fas fa-file-pdf"></i> Estatuto
          </a>
        </div>
        <div class="reglamento">
          <a href="reglamento-interno (1).pdf" download="Reglamento Interno.pdf" class="text-white">
            <i class="fas fa-file-pdf"></i> Reglamento Interno
          </a>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <p class="text-muted mb-0">© <?php echo date("Y"); ?> Asotaeco. Todos los derechos reservados.</p>
      </div>
    </div>
  </div>
</footer>
 `;
  }
  function filtrarPorGenero(filtroIn) {
    if (filtroIn === "") {
      mostrarElementosEnBloques(data);
    } else {
      const filteredData = data.filter((producto) => {
        const generoProducto = producto.genero.toLowerCase();
        const ocasionProducto = producto.ocasion.toLowerCase();
        if (filtroIn === "Uniforme Escolar" || filtroIn === "Deportivo") {
          return ocasionProducto === filtroIn.toLowerCase();
        } else if (filtroIn === "Niños") {
          return (
            generoProducto.includes("niño") || generoProducto.includes("niña")
          );
        } else {
          return (
            generoProducto === filtroIn.toLowerCase() ||
            ocasionProducto === filtroIn.toLowerCase()
          );
        }
      });
      renderPagination(filteredData.length);
      currentPage = 1;
      mostrarElementosEnBloques(filteredData);
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
          swal("Excelente!", "Transaccion realizada con exito", "success");
        }
      })
      .catch((error) => {
        console.error("Error al enviar los datos:", error);
      });
  });
  const campoBusqueda = document.getElementById("searchInput");

  campoBusqueda.addEventListener("input", function () {
    const keywords = campoBusqueda.value.toLowerCase().trim();
    const productosFiltrados = data.filter((producto) => {
      const nombreProducto = producto.nombre.toLowerCase();
      return nombreProducto.includes(keywords);
    });
    mostrarElementosEnBloques(productosFiltrados);
  });

  document.getElementById("btnall").addEventListener("click", function () {
    var url = new URL(window.location.href);
    url.searchParams.delete("filter");
    window.location.href = url.toString();
    filtrarPorGenero("");
  });

  document.getElementById("btnmujer").addEventListener("click", function () {
    filtrarPorGenero("Mujer");
  });

  document.getElementById("btnhombre").addEventListener("click", function () {
    filtrarPorGenero("Hombre");
  });

  document.getElementById("btnninio").addEventListener("click", function () {
    filtrarPorGenero("Niño");
  });

  document.getElementById("btnninia").addEventListener("click", function () {
    filtrarPorGenero("Niña");
  });
});
