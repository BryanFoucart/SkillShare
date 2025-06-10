import { validateRegisterForm } from "../../services/validate.js";

document.addEventListener("DOMContentLoaded", () => {
  // redirection si connecté
  const registerForm = document.querySelector("#register-form");
  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();
    // réinitialisation des champ erreurs à vide
    registerForm
      .querySelectorAll(".error")
      .forEach((span) => (span.textContent = ""));
    registerForm
      .querySelectorAll(".error-input")
      .forEach((input) => input.classList.remove("error-input"));
    // validation données
    const { valid, errors } = validateRegisterForm(registerForm);

    if (!valid) {
      for (const [field, message] of Object.entries(errors)) {
        const errorSpan = registerForm.querySelector(`[data-error="${field}"]`);
        if (errorSpan) errorSpan.textContent = message;

        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
          input.classList.add("error-input");
        }
      }
    }
  });
});
