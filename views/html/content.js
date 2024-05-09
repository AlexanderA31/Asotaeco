document.addEventListener("DOMContentLoaded", function () {
  reloadSection();
  function soloNumeros(event) {
    var codigoTecla = event.keyCode || event.which;
    if (
      (codigoTecla >= 48 && codigoTecla <= 57) ||
      (codigoTecla >= 96 && codigoTecla <= 105) || // dígitos numéricos
      codigoTecla === 8 ||
      codigoTecla === 46 || // backspace y delete
      codigoTecla === 37 ||
      codigoTecla === 39
    ) {
      return true;
    } else {
      return false;
    }
  }
});
function reloadSection() {
  try {
    fetch("../../controllers/router.php?op=getCategorias")
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Hubo un problema al obtener los detalles del producto."
          );
        }
        return response.json();
      })
      .then((data) => {
        // Obtener los elementos <ul> donde se agregarán los elementos
        const ul = document.getElementById("subMenuCat");
        // Limpiar el contenido actual de los <ul>
        ul.innerHTML = "";
        // Recorrer los datos y agregar elementos <li> a los <ul> correspondientes

        data.forEach((categoria) => {
          const li = document.createElement("li");
          const a = document.createElement("a");
          a.href = "../shop/index.php?op=" + categoria.tabla; // Puedes establecer el enlace aquí si tienes la URL correspondiente
          a.textContent = categoria.nombre;
          // Crear un nuevo <li> y <a> para cada <ul>
          const li1 = li.cloneNode(true);
          const a1 = a.cloneNode(true);
          li.appendChild(a);
          ul.appendChild(li);
          li1.appendChild(a1);
        });

        // Si hay más de 5 elementos, añadir la clase 'scrollable'
        if (data.length > 5) {
          ul.classList.add("scrollable");
        } else {
          ul.classList.remove("scrollable");
        }
      });
  } catch (error) {
    alert("Error al obtener los detalles del producto:", error);
  }
}
