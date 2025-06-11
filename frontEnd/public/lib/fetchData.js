/**
 * Utilitaire pour gérer les appels API
 */
export async function fetchData({ route, api, options = {} }) {
  const headers = {
    Accept: "application/json",
    ...options.headers,
  };

  //   // Ajouter le token JWT si présent
  //   const token = localStorage.getItem('token');
  //   if (token) {
  //     headers['Authorization'] = `Bearer ${token}`;
  //   }

  // Si ce n'est pas un FormData, ajouter Content-Type: application/json
  if (!(options.body instanceof FormData)) {
    headers["Content-Type"] = "application/json";
  }

  //ChatGPT
  // Construire l'URL complète
  // const url = new URL(route, api).toString();

  // try {
  //   const response = await fetch(url, {
  //     ...options,
  //     headers,
  //   });

  //   if (!response.ok) {
  //     throw new Error(`HTTP error! status: ${response.status}`);
  //   }

  //   const data = await response.json();
  //   return data;
  // } catch (error) {
  //   console.error("Fetch error:", error);
  //   throw error;
  // }
  // ChatGPT

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

  // VERSION COPILOT START
  // try {
  //   const result = await fetch(`${api}${route}${queryString}`, {
  //     ...options,
  //     headers,
  //   });

  //   // Vérifier le Content-Type de la réponse
  //   const contentType = result.headers.get("content-type");
  //   if (!contentType || !contentType.includes("application/json")) {
  //     const text = await result.text();
  //     console.error("Réponse non-JSON:", text);
  //     throw new Error(
  //       `Réponse invalide du serveur: ${text.substring(0, 100)}...`
  //     );
  //   }

  //   const jsonData = await result.json();

  //   if (!result.ok) {
  //     throw new Error(
  //       jsonData.error || `Erreur ${result.status}: ${result.statusText}`
  //     );
  //   }

  //   return jsonData;
  // } catch (error) {
  //   console.error("Erreur fetch:", error);
  //   throw error;
  // }
  // VERSION COPILOT END
}
