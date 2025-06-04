import express from "express";
import helmet from "helmet";
import path from "path";
import indexRoutes from "./routes/index.js";

const app = express();
const __dirname = path.resolve();

app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

app.use("/", indexRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(
    `serveur en écoute sur le port ${PORT}, disponible à l'adresse http://localhost:${PORT}`
  );
});
