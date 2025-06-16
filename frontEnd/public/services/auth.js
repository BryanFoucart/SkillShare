export class AuthManager {
  static isLoggedIn() {
    // return !!localStorage.getItem("JWTToken");
    const token = localStorage.getItem("JWTToken");
    if (!token || this.isTokenExpired()) {
      const currentPath = encodeURIComponent(window.location.pathname);
      this.logout();
      window.location.href = `/connexion?redirect=${currentPath}`;
      return false;
    }
    return true;
  }

  static getUser() {
    const userStr = localStorage.getItem("user");
    return userStr ? JSON.parse(userStr) : null;
  }

  static updateNavbar() {
    const navLinks = document.querySelector(".nav-links");
    if (!navLinks) {
      console.log("Element UL non trouvé");
      return;
    }
    const isLoggedIn = this.isLoggedIn();
    const user = this.getUser();

    if (isLoggedIn && user) {
      navLinks.innerHTML = `
        <li><a href="/competences">Compétences</a></li>
        <li><a href="/profil">Profil</a></li>
        <li><a href="#" id="logout-btn">Déconnexion</a></li>
      `;

      // Gestion déconnexion
      const logoutBtn = document.querySelector("#logout-btn");
      logoutBtn.addEventListener("click", (e) => {
        e.preventDefault();
        this.logout();
      });
    }
  }

  static logout() {
    localStorage.removeItem("JWTToken");
    localStorage.removeItem("user");
    window.location.href = "/connexion";
  }
}
