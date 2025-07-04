import express from "express";
import helmet from "helmet";
import path from "path";
import dotenv from "dotenv";
import indexRoutes from "./routes/index.js";
dotenv.config();

const app = express();

const API_URL = process.env.API_URL;

app.use(
  helmet({
    contentSecurityPolicy: {
      directives: {
        defaultSrc: ["'self'"],
        scriptSrc: [
          "'self'",
          "'unsafe-inline'",
          "'unsafe-eval'",
          "localhost:*",
        ],
        connectSrc: ["'self'", "ws://localhost:*", API_URL],
        imgSrc: ["'self'", "data:", "blob:", API_URL],
        styleSrc: ["'self'", "'unsafe-inline'"],
        formAction: ["'self'"],
        baseUri: ["'self'"],
      },
    },
    crossOriginEmbedderPolicy: false,
    crossOriginResourcePolicy: { policy: "cross-origin" },
    crossOriginOpenerPolicy: false,
  })
);

const __dirname = path.resolve();

app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Middleware corrects
// app.use(express.json());
// app.use(express.urlencoded({ extended: true }));
// app.use(helmet());
app.use(express.static(path.join(__dirname, "public")));

app.use("/", indexRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(
    `serveur en écoute sur le port ${PORT}, disponible à l'adresse http://localhost:${PORT}`
  );
});
