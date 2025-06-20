import { fetchData } from "../../lib/fetchData.js";
import { AuthManager } from "../../services/auth.js";
import { validateRegisterForm } from "../../services/validate.js";

document.addEventListener("DOMContentLoaded", () => {
  const API_URL = document.querySelector("#api-url").value;
  const infoForm = document.querySelector("#info-form");
  const messageContainer = document.querySelector(".message-container");
  const messageVerify = document.querySelector("#verify-msg");
  // désactiver le button submit
  const submitInfoButton = infoForm.querySelector("button");
  submitInfoButton.setAttribute("disabled", true);

  if (
    !AuthManager.isLoggedIn("Vous devez être connecté pour voir votre profil !")
  ) {
    return;
  }

  const user = AuthManager.getUser();

  if (!user) {
    AuthManager.logout();
    return;
  }

  const usernameInput = document.querySelector("#username");
  const emailInput = document.querySelector("#email");
  // Gestion des infos actuelles du user connecté
  usernameInput.value = user.username;
  emailInput.value = user.email;

  usernameInput.addEventListener("change", () => {
    submitInfoButton.removeAttribute("disabled");
  });

  emailInput.addEventListener("change", () => {
    submitInfoButton.removeAttribute("disabled");
  });

  infoForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    // Réinitialiser les messages d'erreurs
    infoForm
      .querySelectorAll(".error")
      .forEach((span) => (span.textContent = ""));

    const { valid, errors, data } = validateRegisterForm(infoForm);

    if (!valid) {
      for (const [field, message] of Object.entries(errors)) {
        const errorSpan = infoForm.querySelector(`[data-error="${field}"]`);
        if (errorSpan) errorSpan.textContent = message;
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
          input.classList.add("error-input");
        }
      }

      msg.textContent = "";
      return;
    }
    const infoData = new FormData(infoForm);
    const jsonData = {};
    infoData.forEach((value, key) => {
      jsonData[key] = value;
    });

    try {
      const result = await fetchData({
        route: "/api/user/update",
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
        // mise à jour du user en local
        const updatedUser = { ...user, ...jsonData };
        localStorage.setItem("user", JSON.stringify(updatedUser));
        messageVerify.textContent = result.message;
        messageVerify.style.color = "green";
        messageContainer.style.display = "block";
      }
    } catch (error) {
      messageVerify.textContent = error.message;
      messageVerify.style.color = "red";
      messageContainer.style.display = "block";
    }
  });

  // Gérer l'avatar
  const avatarImg = document.getElementById("user-avatar");
  // const UPLOADS_URL = document.getElementById("uploads-url")?.value;
  if (user.avatar) {
    avatarImg.src = `${API_URL}/uploads/avatar/${user.avatar}`;
  } else {
    avatarImg.src = "/uploads/avatar_old/default-avatar.jpg";
  }
  // Gérer le formulaire d'avatar
  const avatarForm = document.getElementById("avatar-form");
  const avatarInput = document.getElementById("avatar-input");
  const avatarMsg = document.getElementById("avatar-msg");

  avatarForm?.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Préparer le fichier pour l'upload
    const formData = new FormData();
    const file = avatarInput.files[0];
    if (!file) {
      avatarMsg.textContent = "Veuillez sélectionner un fichier";
      avatarMsg.className = "error";
      return;
    }
    formData.append("avatar", file);

    try {
      const result = await fetchData({
        route: "/api/user/update-avatar",
        api: API_URL,
        options: {
          method: "POST",
          body: formData,
        },
      });

      if (result.success) {
        // Mettre à jour l'avatar dans le localStorage
        const updatedUser = { ...user, avatar: result.avatar };
        localStorage.setItem("user", JSON.stringify(updatedUser));

        // Mettre à jour l'image
        avatarImg.src = `${API_URL}/uploads/avatar/${updatedUser.avatar}`;
      }
    } catch (error) {
      console.error("Erreur lors de la mise à jour de l'avatar:", error);
    }
  });
  // Gérer la demande de réinitialisation du mot de passe
  const resetBtn = document.getElementById("request-reset-btn");
  const resetMsg = document.getElementById("reset-msg");
  console.log(resetBtn);
  console.log(resetMsg);

  resetBtn?.addEventListener("click", async () => {
    try {
      const result = await fetchData({
        route: "/api/user/request-reset",
        api: API_URL,
        options: {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email: user.email }),
        },
      });

      if (result.success) {
        resetMsg.textContent = "Un email de réinitialisation vous a été envoyé";
        resetMsg.className = "success";
        resetBtn.disabled = true;
      }
    } catch (error) {
      resetMsg.textContent = error.message || "Erreur lors de la demande";
      resetMsg.className = "error";
    }
  });
});
