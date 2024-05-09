document.addEventListener("DOMContentLoaded", async function () {
  function limitarCaracteres(input, maxLength) {
    if (input.value.length > maxLength) {
      input.value = input.value.slice(0, maxLength);
    }
  }
  timeS = 2000;
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

  let iduser = 0;
  fetch("../../controllers/router.php?op=getUserData")
    .then((response) => {
      if (response.ok) {
        return response.json(); // Convertir la respuesta a JSON
      }
      throw new Error("Error al obtener los datos del perfil");
    })
    .then((data) => {
      // Asignar los datos del perfil a los campos del formulario
      metodoCantones(data.provincia, data.canton);
      iduser = data.id;
      document.getElementById("id_hidden").value = data.id;
      document.getElementById("provincias").value = data.provincia;
      document.getElementById("cedula").value = data.cedula;
      document.getElementById("email").value = data.email;
      document.getElementById("nombres").value = data.nombre;
      document.getElementById("referencia").value = data.referencia;
      document.getElementById("direccion").value = data.direccion;
      document.getElementById("telefono").value = data.telefono;
      document.getElementById("canton").value = data.canton;
      setLoading(false);
    })
    .catch((error) => {
      setLoading(false);
      console.error("Error:", error);
      // Aquí puedes manejar el error de alguna manera, por ejemplo, mostrando un mensaje al usuario
    });
  document
    .getElementById("btnActualizar")
    .addEventListener("click", function () {
      timeS = 2000;
      setLoading(true);
      const id = document.getElementById("id_hidden").value;
      const nombres = document.getElementById("nombres").value;
      const direccion = document.getElementById("direccion").value;
      const email = document.getElementById("email").value;
      const provincia = document.getElementById("provincias").value;
      const canton = document.getElementById("canton").value;
      const referencia = document.getElementById("referencia").value;
      const cedula = document.getElementById("cedula").value;
      const telefono = document.getElementById("telefono").value;
      const formData = new FormData();
      formData.append("nombre", nombres);
      formData.append("id", id);
      formData.append("provincia", provincia);
      formData.append("canton", canton);
      formData.append("referencia", referencia);
      formData.append("direccion", direccion);
      formData.append("email", email);
      formData.append("cedula", cedula);
      formData.append("telefono", telefono);

      fetch("../../controllers/router.php?op=updateUser", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (response.ok) {
            swal("Excelente!", "Transacción realizada con éxito", "success");
          }
          setLoading(false);
        })
        .catch((error) => {
          setLoading(false);
          // Capturar y manejar cualquier error que ocurra durante la solicitud
          console.error("Error al enviar los datos:", error);
        });
    });

  document
    .getElementById("btnCambiarPass")
    .addEventListener("click", function () {
      const id = document.getElementById("id").value;
      const pass = document.getElementById("pass").value;
      const confpass = document.getElementById("confPass").value;
      
      // Validar que las contraseñas coincidan
      if (pass !== confpass) {
        swal("Error", "Las contraseñas no coinciden", "error");
        return; // Detener el envío del formulario si las contraseñas no coinciden
      }
      
      // Validar que la longitud de la contraseña sea al menos 8 caracteres
      if (pass.length < 8) {
        swal(
          "Error",
          "La contraseña debe tener al menos 8 caracteres",
          "error"
        );
        return; // Detener el envío del formulario si la contraseña es demasiado corta
      }
      
      // Si pasa la validación, continuar con el envío de datos
      const formData = new FormData();
      formData.append("pass", pass);
      formData.append("id_user", id);
      
      setLoading(true);
      fetch("../../controllers/router.php?op=cambiarPass", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (response.ok) {
            swal("Excelente!", "Transacción realizada con éxito", "success");
          }
          setLoading(false);
        })
        .catch((error) => {
          setLoading(false);
          console.error("Error al enviar los datos:", error);
        });
    });
});
