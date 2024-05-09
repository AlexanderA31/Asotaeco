document.addEventListener("DOMContentLoaded", async function () {
  setLoading(false);

  document.getElementById("btnEntrar").addEventListener("click", submitForm);
  function submitForm() {
    setLoading(true);
    const form = document.getElementById("registroForm");
    const formData = new FormData(form);
    fetch("../../controllers/router.php?op=registro", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal(
            "Ups! Algo salió mal!",
            "Revise que su email o numero de cédula no se encuentre ya registrado!",
            "error"
          );
          throw new Error("Error en la solicitud");
        }
        setLoading(false);
        swal("Excelente!", "Éxito al registrarse!", "success");
        window.location.href = "../login/";
      })
      .catch((error) => {
        setLoading(false);
        swal("Error", error, "error");
      });
  }

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
        const selectProvincias = document.getElementById("provincia");
        selectProvincias.innerHTML = "";

        data.forEach((provincia) => {
          const option = document.createElement("option");
          option.value = provincia;
          option.textContent = provincia;
          selectProvincias.appendChild(option);
        });

        metodoCantones(data[0]);
      })
      .catch((error) => {
        swal("Error", "Provincias " + error, "error");
      });
    const selectProducto = document.getElementById("provincia");
    selectProducto.addEventListener("change", () => {
      const productId = selectProducto.value;
      metodoCantones(productId);
    });
  }

  function metodoCantones(productId) {
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
        swal("Error", "Cantones " + error, "error");
      });
  }
});
