import { User } from './classe/User.js';

function validateRegisterForm()
{
    let registerForm = document.getElementById('register-form');
    let isValid = null;

    registerForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm-password').value;

        let user = new User(username, email, password, confirmPassword);
        let validate = user.validate();

        let formData = new FormData();
        formData.append('username', username);
        formData.append('submit-new-user', true);

        let options = {
            method: 'POST',
            body: formData
        };

        fetch('/res04-projet-soutenance/register', options)
        .then(response => response.json())
        .then(data => {
            if(data.exists)
            {
                let errorUsername = document.querySelector('.errorUsername');
                errorUsername.textContent = "This username already exists";
                isValid = false;
            }
            else if(!validate)
            {
                isValid = false;
            }
            else
            {
                isValid = true;
            }
        })
        .catch(error => {
            console.error('An error occured: ' + error);
        })
        .finally(() => {
            if(isValid === true)
            {
                registerForm.submit();
            }
        })
    });
}

export { validateRegisterForm };