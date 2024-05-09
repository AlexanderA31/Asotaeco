document.addEventListener("DOMContentLoaded", function () {
  setLoading(false);
  document.getElementById("btnentrar").addEventListener("click", submitForm);
  function submitForm(event) {
    event.preventDefault();
    console.log("Entraa");
    setLoading(true);
    timeS = 5000;
    const form = document.getElementById("miForm");
    const formData = new FormData(form);
    fetch("../../controllers/router.php?op=resetpassci", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          swal("Algo salio mal!" + response, "error");
          throw new Error("Error en la solicitud");
        }
        swal("Excelente!", "Se a enviado el email de recuperación!", "success");
        setLoading(false);
      })
      .catch((error) => {
        setLoading(false);
        swal("Ups! Algo salió mal!", error, "error");
      });
  }
});
