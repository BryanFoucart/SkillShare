import { AuthManager } from "../../services/auth.js";

document.addEventListener("DOMContentLoaded", async () => {
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

  infoForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const infoData = new FormData(infoForm);
  });

  const jsonData = {};
  infoData.forEach((value, key) => {
    if (key !== "avatar") {
      jsonData[key] = value;
    }
  });

  try {
    const result = await fetchData({
      route: "/api/update",
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
      localStorage.setItem("JWTtoken", result.token);
      localStorage.setItem("user", JSON.stringify(result.user));
      messageVerify.textContent = "Modification réussie";
      messageContainer.style.display = "block";
      messageVerify.style.color = "green";

      AuthManager.updateNavbar();

      setTimeout(() => {
        const params = new URLSearchParams(window.location.search);
        const redirect = params.get("redirect") || "/";
        window.location.href = redirect;
      }, 2000);
    }
  } catch (error) {
    messageVerify.textContent = error.message;
    messageContainer.style.display = "block";
    messageVerify.style.color = "red";
  }
});
