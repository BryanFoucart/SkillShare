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

export default router;
