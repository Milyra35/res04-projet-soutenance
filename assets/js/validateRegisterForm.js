import { User } from './classe/User.js';

function validateRegisterForm()
{
    let registerForm = document.getElementById('register-form');

    registerForm.addEventListener("submit", function(event) {

        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm-password').value;

        let user = new User(username, email, password, confirmPassword);
        // console.log(user);

        let validate = user.validate();

        if(!validate)
        {
            // If the informations are not correct, the form is not submitted
            event.preventDefault();
        }
    })
}

export { validateRegisterForm };