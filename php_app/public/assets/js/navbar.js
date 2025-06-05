document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector(".navbar .toggle");
  const navLinks = document.querySelector(".navbar .nav-links");

  if (toggleBtn && navLinks) {
    toggleBtn.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  }
});
