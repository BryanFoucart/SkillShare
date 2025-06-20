import express from "express";
const router = express.Router();

const globals = {
  API_URL: process.env.API_URL || "http://localhost:8000",
};

router.get("/", (req, res) => {
  res.render("layout", {
    title: "Accueil",
    view: "pages/home",
  });
});

router.get("/inscription", (req, res) => {
  res.render("layout", {
    title: "Inscription",
    view: "pages/register",
    ...globals,
  });
});

router.get("/verify-email", (req, res) => {
  res.render("layout", {
    title: "Vérification email",
    view: "pages/verify-email",
    ...globals,
  });
});

router.get("/connexion", (req, res) => {
  res.render("layout", {
    title: "Connexion",
    view: "pages/connexion",
    ...globals,
  });
});

router.get("/competences", (req, res) => {
  res.render("layout", {
    title: "Compétences",
    view: "pages/competences",
    ...globals,
  });
});

router.get("/profil", (req, res) => {
  res.render("layout", {
    title: "Profil",
    view: "pages/profil",
    ...globals,
  });
});

router.get("/dashboard", (req, res) => {
  res.render("layout", {
    title: "Dashboard",
    view: "pages/dashboard",
    ...globals,
  });
});

router.get("/reset-password", (req, res) => {
  res.render("layout", {
    title: "Réinitialisation du mot de passe",
    view: "pages/reset-password",
    token: req.query.token,
    ...globals,
  });
});

// Cette route doit être placée en dernier pour capturer toutes les routes non définies
router.use((req, res, next) => {
  console.log("Route 404 activée pour:", req.path); // Log pour le débogage
  return res.status(404).render("layout", {
    title: "Page non trouvée",
    view: "pages/error-404",
    ...globals,
  });
});

export default router;
