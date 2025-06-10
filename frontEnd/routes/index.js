import express from "express";
const router = express.Router();

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
  });
});

export default router;
