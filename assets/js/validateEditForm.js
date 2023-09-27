import { User } from './classe/User.js';

function validateEditForm()
{
    let registerForm = document.getElementById('edit-admin-form');

    registerForm.addEventListener("submit", function(event) {

        let username = document.getElementById('new-username').value;
        let email = document.getElementById('new-email').value;
        let password = document.getElementById('new-password').value;
        let confirmPassword = document.getElementById('confirm-new-password').value;

        let user = new User(username, email, password, confirmPassword);

        let validate = user.validate();

        if(!validate)
        {
            // If the informations are not correct, the form is not submitted
            event.preventDefault();
        }
    })
}

export { validateEditForm };