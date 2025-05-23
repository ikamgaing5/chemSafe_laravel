function validForm() {
    // Récupération des champs
    const username = document.getElementById("nomuser").value.trim();
    const name = document.getElementById("name").value.trim();
    const role = document.getElementById("role").value;
    const usine = document.getElementById("usine").value;
    const password = document
        .querySelector('input[name="password"]')
        .value.trim();
    const passwordConfirmation = document
        .querySelector('input[name="password_confirmation"]')
        .value.trim();

    // Réinitialisation des messages d'erreur
    document
        .querySelectorAll(".text-danger")
        .forEach((span) => (span.textContent = ""));

    let isValid = true;

    // Validation du nom d'utilisateur
    if (username === "") {
        document.getElementById("messageNom").textContent =
            "Le nom d'utilisateur est requis";
        isValid = false;
    }

    // Validation du nom/prénom
    if (name === "") {
        document.getElementById("messageMdp").textContent =
            "Le nom ou prénom est requis";
        isValid = false;
    }

    // Validation du rôle
    if (role === "none") {
        document.getElementById("messageRole").textContent =
            "Veuillez sélectionner un rôle";
        isValid = false;
    }

    // Validation de l'usine
    if (usine === "none") {
        document.getElementById("messageUsine").textContent =
            "Veuillez sélectionner une usine";
        isValid = false;
    }

    // Validation du mot de passe
    if (password === "") {
        document.querySelector(
            'input[name="password"]'
        ).nextElementSibling.textContent = "Le mot de passe est requis";
        isValid = false;
    }

    // Validation de la confirmation du mot de passe
    if (passwordConfirmation === "") {
        document.querySelector(
            'input[name="password_confirmation"]'
        ).nextElementSibling.textContent =
            "La confirmation du mot de passe est requise";
        isValid = false;
    }

    // Vérification de la correspondance des mots de passe
    if (password !== passwordConfirmation) {
        document.querySelector(
            'input[name="password_confirmation"]'
        ).nextElementSibling.textContent =
            "Les mots de passe ne correspondent pas";
        isValid = false;
    }

    // Vérification des exigences de mot de passe Laravel 12
    const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordRegex.test(password)) {
        document.querySelector(
            'input[name="password"]'
        ).nextElementSibling.textContent =
            "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
        isValid = false;
    }

    return isValid;
}

// Ajout des écouteurs d'événements pour la validation en temps réel
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const inputs = form.querySelectorAll("input, select");

    // Validation en temps réel pour l'usine
    const usineSelect = document.getElementById("usine");
    if (usineSelect) {
        usineSelect.addEventListener("change", function () {
            const errorSpan = document.getElementById("messageUsine");
            if (errorSpan) {
                if (this.value === "none") {
                    errorSpan.textContent = "Veuillez sélectionner une usine";
                } else {
                    errorSpan.textContent = "";
                }
            }
        });
    }

    // Validation en temps réel pour les autres champs
    inputs.forEach((input) => {
        input.addEventListener("input", function () {
            const errorSpan = this.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains("text-danger")) {
                errorSpan.textContent = "";
            }
        });
    });
});
