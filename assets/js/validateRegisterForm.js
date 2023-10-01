import { User } from './classe/User.js';

function validateRegisterForm()
{
    let registerForm = document.getElementById('register-form');

    registerForm.addEventListener("submit", async function(event) {
        event.preventDefault();

        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm-password').value;

        // Effectuez une validation plus détaillée ici (longueur minimale, adresse e-mail valide, correspondance des mots de passe, etc.)

        // Créez un objet FormData pour envoyer les données au serveur
        let formData = new FormData();
        formData.append('username', username);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('confirmPassword', confirmPassword);

        try {
            let response = await fetch('/res04-projet-soutenance/register', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                console.log(response);
                // L'inscription s'est bien déroulée, redirigez l'utilisateur vers une page de confirmation
                // window.location.href = '/res04-projet-soutenance/login';
            } else {
                // Gérez les erreurs du serveur et fournissez un message d'erreur approprié à l'utilisateur
                let errorResponse = await response.json();
                if (errorResponse && errorResponse.error) {
                    let errorElement = document.querySelector('.errorUsername');
                    errorElement.textContent = errorResponse.error;
                } else {
                    console.error('Erreur inattendue du serveur');
                }
            }
        } catch (error) {
            console.error('Erreur lors de la requête fetch', error);
        }
    });
}

export { validateRegisterForm };