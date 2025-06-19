import { fetchData } from "../../lib/fetchData.js";
import { validateRegisterForm } from "../../services/validate.js";

document.addEventListener("DOMContentLoaded", () => {
  // redirection si connecté
  const registerForm = document.querySelector("#register-form");
  const API_URL = document.querySelector("#api-url").value;
  const messageContainer = document.querySelector(".message-container");
  const message = document.querySelector("#verify-msg");
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

    // Si un fichier avatar est présent, créer un formData
    const avatarFile = formData.get("avatar");
    if (avatarFile && avatarFile.size > 0) {
      const avatarFileData = new FormData();
      avatarFileData.append("avatar", avatarFile);
      try {
        const result = await fetchData({
          route: "/api/upload-avatar",
          api: API_URL,
          options: {
            method: "POST",
            body: avatarFileData,
          },
        });
        jsonData.avatar = result.filename;
      } catch (error) {
        // message utilisateur ...
      }
    }

    try {
      const result = await fetchData({
        route: "/api/register",
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
        registerForm.reset();
        messageContainer.style.display = "block";
        message.textContent =
          "Un email de vérification vous a été envoyé pour compléter l'inscription";
        message.style.color = "green";
      }
    } catch (error) {
      message.textContent = error.message;
      messageContainer.style.display = "block";
      message.style.color = "red";
    }
    // // transforme l'objet en fichier .json
    // const jsonDataString = JSON.stringify(jsonData);
    // console.log(jsonDataString);
  });
});
