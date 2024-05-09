const scrollbar = document.querySelector(".scrollbar");
const content = document.querySelector(".content");

// Escucha el evento de scroll del contenido
content.addEventListener("scroll", () => {
  // Obtén la posición actual de la barra de desplazamiento
  const scrollPosition = scrollbar.scrollTop;

  // Actualiza la posición de la barra de desplazamiento
  scrollbar.scrollTop = scrollPosition;
});