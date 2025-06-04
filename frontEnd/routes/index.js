import express from "express";
const router = express.Router();

router.get("/", (req, res) => {
  res.render("layout", {
    title: "Accueil",
    view: "pages/home",
    message: "Bienvenue sur notre site !",
  });
});

export default router;
