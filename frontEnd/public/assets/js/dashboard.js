import { AuthManager } from "../../services/auth.js";

window.addEventListener("DOMContentLoaded", () => {
  // Vérification des droits d'accès à la page
  console.log(AuthManager.checkAdminAccess());
  if (!AuthManager.checkAdminAccess()) {
    // Si checkAdminAccess renvoie false, la redirection est déjà gérée dans la méthode
    return;
  }

  // Initialisation du dashboard pour les admins
  console.log("Dashboard admin chargé");
  // initDashboard();
});
