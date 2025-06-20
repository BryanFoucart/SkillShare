import { fetchData } from "../../lib/fetchData.js";

document.addEventListener("DOMContentLoaded", async () => {
  const API_URL = document.getElementById("api-url")?.value;
  console.log("Initial API_URL:", API_URL); // Log pour debug
  const resetForm = document.getElementById("reset-form");
  const resetMsg = document.getElementById("reset-msg");

  // Récupérer le token depuis l'input caché
  const token = document.getElementById("reset-token")?.value;
  console.log("Reset token:", token); // Log pour debug

  if (!token) {
    resetMsg.textContent =
      "Token manquant. Veuillez utiliser le lien fourni dans l'email.";
    resetMsg.className = "error";
    resetForm.style.display = "none";
    return;
  }

  resetForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(resetForm);
    const password = formData.get("password");
    const confirmPassword = formData.get("confirmPassword");

    // Vérification des mots de passe
    if (password !== confirmPassword) {
      resetMsg.textContent = "Les mots de passe ne correspondent pas";
      resetMsg.className = "error";
      return;
    }

    try {
      console.log(
        "Sending reset password request to:",
        `${API_URL}/user/reset-password`
      );
      console.log("API URL:", API_URL);
      const result = await fetchData({
        route: "/api/user/reset-password",
        api: API_URL,
        options: {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ token, password }),
        },
      });

      if (result.success) {
        resetMsg.textContent = result.message;
        resetMsg.className = "success";
        resetForm.style.display = "none";

        // Rediriger vers la page de connexion après 3 secondes
        setTimeout(() => {
          window.location.href = "/connexion";
        }, 3000);
      }
    } catch (error) {
      resetMsg.textContent =
        error.message || "Erreur lors de la réinitialisation";
      resetMsg.className = "error";
    }
  });
});
