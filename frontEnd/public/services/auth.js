export class AuthManager {
  static isLoggedIn() {
    // return !!localStorage.getItem('JWTtoken');
    const token = localStorage.getItem("JWTtoken");
    // route autorisé sans connexion
    const notAllowedPaths = ["%2Fcompetences"];

    if (!token || this.isTokenExpired(token)) {
      const currentPath = encodeURIComponent(window.location.pathname);
      this.logout();
      if (notAllowedPaths.includes(currentPath)) {
        window.location.href = `/connexion?redirect=${currentPath}`;
      }
      return false;
    }
    return true;
  }

  static isTokenExpired(token) {
    if (!token) return true;
    try {
      const payload = JSON.parse(atob(token.split(".")[1]));
      console.log(Date.now());
      console.log(payload.exp);
      return payload.exp < Date.now() / 1000;
    } catch (error) {
      return true;
    }
  }

  static getUser() {
    const userStr = localStorage.getItem("user");
    return userStr ? JSON.parse(userStr) : null;
  }

  static isAdmin() {
    try {
      const user = this.getUser();
      if (!user || !Array.isArray(user.role)) return false;
      return user.role.includes("ROLE_ADMIN");
    } catch (error) {
      console.error("Erreur lors de la vérification admin :", error);
      return false;
    }
  }

  static updateNavbar() {
    const navLinks = document.querySelector(".nav-links");
    if (!navLinks) {
      console.log("Element UL non trouvé");
      return;
    }
    const isLoggedIn = this.isLoggedIn();
    const user = this.getUser();
    const isAdmin = this.isAdmin();

    if (isLoggedIn && user) {
      navLinks.innerHTML = `
        <li><a href="/competences">Compétences</a></li>
        <li><a href="/profil">Profil</a></li>
        ${isAdmin ? '<li><a href="/dashboard">Dashboard</a></li>' : ""}
        <li><a href="#" id="logout-btn">Déconnexion</a></li>
      `;

      // Gestion déconnexion
      const logoutBtn = document.querySelector("#logout-btn");
      logoutBtn.addEventListener("click", (e) => {
        e.preventDefault();
        this.logout();
        window.location.href = "/connexion";
      });
    }
  }

  static logout() {
    localStorage.removeItem("JWTtoken");
    localStorage.removeItem("user");
  }
}
