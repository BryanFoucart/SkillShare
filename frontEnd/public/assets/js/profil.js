import { fetchData } from "../../lib/fetchData.js";
import { AuthManager } from "../../services/auth.js";

document.addEventListener("DOMContentLoaded", () => {
  const API_URL = document.querySelector("#api-url").value;
  const infoForm = document.querySelector("#info-form");
  const messageContainer = document.querySelector(".message-container");
  const messageVerify = document.querySelector("#verify-msg");

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

  // Gestion des infos actuelles du user connecté
  document.querySelector("#username").value = user.username;

  infoForm.addEventListener("submit", async (e) => {
    e.preventDefault();
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
});
