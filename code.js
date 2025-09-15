// Sélection des éléments
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

// Clic sur le hamburger
hamburger.addEventListener('click', () => {
  // Toggle la classe active pour l'animation croix
  hamburger.classList.toggle('active');

  // Toggle la classe active pour afficher/masquer les liens
  navLinks.classList.toggle('active');
});


 const menu = document.getElementById("menu");
  const toggle = document.getElementById("menuToggle");
  const links = menu.querySelectorAll("a");

  // ouvrir / fermer menu
  toggle.addEventListener("click", () => {
    menu.classList.toggle("open");
  });

  // fermer menu après clic sur un lien
  links.forEach(link => {
    link.addEventListener("click", () => {
      menu.classList.remove("open");
    });
  });