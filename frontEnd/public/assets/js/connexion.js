import { fetchData } from "../../lib/fetchData.js";
import { AuthManager } from "../../services/auth.js";
import { validateRegisterForm } from "../../services/validate.js";

document.addEventListener("DOMContentLoaded", () => {
  // rediriger si déjà connecté
  if (AuthManager.isLoggedIn()) {
    window.location.href = "/";
    return;
  }

  const loginForm = document.querySelector("#login-form");
  const API_URL = document.querySelector("#api-url").value;
  const messageContainer = document.querySelector(".message-container");
  const message = document.querySelector("#verify-msg");

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    loginForm
      .querySelectorAll("#error")
      .forEach((span) => (span.textContent = ""));

    // etat de chargement ...

    loginForm
      .querySelectorAll(".error-input")
      .forEach((input) => input.classList.remove("error-input"));
    // validation données
    const { valid, errors } = validateRegisterForm(loginForm);

    if (!valid) {
      for (const [field, message] of Object.entries(errors)) {
        const errorSpan = loginForm.querySelector(`[data-error="${field}"]`);
        if (errorSpan) errorSpan.textContent = message;

        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
          input.classList.add("error-input");
        }
      }
      return;
    }
    // Récupération des saisies via les attributs 'name' => clé:valeur
    const formData = new FormData(loginForm);

    const jsonData = {};
    formData.forEach((value, key) => {
      jsonData[key] = value;
    });

    try {
      const result = await fetchData({
        route: "/api/login",
        api: API_URL,
        options: {
          method: "POST",
          body: JSON.stringify(jsonData),
        },
      });
      if (!result.success) {
        throw new Error(result.error);
      }
      if (result.success) {
        localStorage.setItem("JWTToken", result.token);
        localStorage.setItem("user", JSON.stringify(result.user));
        message.textContent = "Connexion réussie";
        messageContainer.style.display = "block";
        message.style.color = "green";

        AuthManager.updateNavbar();

        setTimeout(() => {
          window.location.href = "/";
        }, 2000);
      }
    } catch (error) {
      message.textContent = error.message;
      messageContainer.style.display = "block";
      message.style.color = "red";
    }
  });
});
