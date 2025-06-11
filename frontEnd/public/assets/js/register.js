import { fetchData } from "../../lib/fetchData.js";
import { validateRegisterForm } from "../../services/validate.js";

document.addEventListener("DOMContentLoaded", () => {
  // redirection si connecté
  const registerForm = document.querySelector("#register-form");
  const API_URL = document.querySelector("#api-url").value;
  console.log(API_URL);
  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    // réinitialisation des champ erreurs à vide
    registerForm
      .querySelectorAll(".error")
      .forEach((span) => (span.textContent = ""));
    registerForm
      .querySelectorAll(".error-input")
      .forEach((input) => input.classList.remove("error-input"));
    // validation données
    const { valid, errors } = validateRegisterForm(registerForm);

    if (!valid) {
      for (const [field, message] of Object.entries(errors)) {
        const errorSpan = registerForm.querySelector(`[data-error="${field}"]`);
        if (errorSpan) errorSpan.textContent = message;

        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
          input.classList.add("error-input");
        }
      }
      return;
    }

    // Récupération des saisies via les attributs 'name' => clé:valeur
    const formData = new FormData(registerForm);

    const jsonData = {};
    formData.forEach((value, key) => {
      if (key !== "avatar") {
        jsonData[key] = value;
      }
    });

    try {
      const result = await fetchData({
        route: "/api/register",
        api: API_URL,
        options: {
          method: "POST",
          body: JSON.stringify(jsonData),
        },
      });
    } catch (error) {
      // message utilisateur ...
    }
    // // transforme l'objet en fichier .json
    // const jsonDataString = JSON.stringify(jsonData);
    // console.log(jsonDataString);
  });
});
