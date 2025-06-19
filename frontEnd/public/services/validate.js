export function validateRegisterForm(form) {
  const formData = new FormData(form);
  const register = document.querySelector("#register-form");
  const errors = {};
  // console.log(formData.get("email"));
  if (formData.get("username") !== null && !formData.get("username").trim())
    errors.username = "Le nom d'utilisateur est requis";
  // console.log(errors.username);

  const emailRegex = new RegExp(
    "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$"
  );
  const email = formData.get("email").trim();
  if (!emailRegex.test(email)) {
    errors.email = "Email invalide";
    console.log(errors.email);
  }
  // Regex mot de passe : 12 caractères minimum, 1 majuscule, 1 chiffre, 1 charactère spécial

  const passwordRegex = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&])[A-Za-z\\d@$!%*?&]{12,}$"
  );
  const password = formData.get("password").trim();
  if (!passwordRegex.test(password)) {
    errors.password = "Mot de passe invalide";
    console.log(errors.password);
  }

  if (formData.get("avatar")) {
    const file = formData.get("avatar");
    let errorsAvatarTab = [];
    // if (!file.name) {
    //   errorsAvatarTab.push("Fichier - Avatar obligatoire !");
    // }
    if (file.name && !file.type.match(/^image\/(png|jpg|jpeg)$/)) {
      errorsAvatarTab.push("Extension incorrecte [png|jpg|jpeg]");
      // console.log(errors.avatar);
    }

    const maxSize = 2 * 1024 * 1024; //2MB
    if (file.name && file.size > maxSize) {
      errorsAvatarTab.push(`\nFichier trop volumineux [max: 2MB]`);
      // console.log(errors.avatar);
    }

    if (errorsAvatarTab.length > 0) {
      errors.avatar = errorsAvatarTab.join(" ");
      console.log(errors.avatar);
    }
  }

  return {
    valid: Object.keys(errors).length === 0,
    errors,
  };
}
