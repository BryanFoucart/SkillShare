/**
 * Utilitaire pour gérer les appels API
 */ // Ajouter le token JWT si présent
export async function fetchData({ route, api, options = {} }) {
  const token = localStorage.getItem("JWTtoken");
  const headers = {
    Accept: "application/json",
    // Si ce n'est pas un FormData, ajouter Content-Type: application/json
    ...(!(options.body instanceof FormData) && {
      "Content-Type": "application/json",
    }),
    ...(token && { Authorization: `Bearer ${token}` }),
    ...(options.headers || {}),
  };

  // Construire la query string si des paramètres sont présents
  let queryString = "";
  if (options.params) {
    queryString = "?" + new URLSearchParams(options.params).toString();
    delete options.params;
  }

  // Effectuer la requête
  const result = await fetch(`${api}${route}${queryString}`, {
    ...options,
    headers,
  });

  // Traiter la réponse
  const responseData = await result.text();
  let jsonData;
  try {
    jsonData = JSON.parse(responseData);
  } catch (e) {
    console.error("Réponse non-JSON:", responseData);
    throw new Error("Format de réponse invalide");
  }

  if (result.ok) {
    return jsonData;
  }

  throw new Error(jsonData.error || "Erreur serveur");
}
