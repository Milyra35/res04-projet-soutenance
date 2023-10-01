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

        let user = new User(username, email, password, confirmPassword);
        let validate = user.validate();

        // Créez un objet FormData pour envoyer les données au serveur
        let formData = new FormData();
        formData.append('username', username);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('confirmPassword', confirmPassword);

        let options = {
            method: 'POST',
            body: formData
        };

        fetch('/res04-projet-soutenance/register', options)
        .then(response => {
            if (validate && response.ok) {
                console.log(response.status);
                // window.location.href = '/res04-projet-soutenance/login';
            } 
            else if (response.status === 400) 
            {
                // Gérez les erreurs du serveur et affichez le message d'erreur
                return response.json().then(data => {
                    let error = document.querySelector('.errorUsername');
                    error.textContent = data.message;
                });
            }
        })
        .catch(error => {
            console.error('Erreur de la requête fetch', error);
        });
    });
}

export { validateRegisterForm };