import { User } from './classe/User.js';

function validateEditUserForm()
{
    let registerForm = document.getElementById('edit-user-form');

    registerForm.addEventListener("submit", function(event) {

        let username = document.getElementById('new-user-username').value;
        let email = document.getElementById('new-user-email').value;
        let password = document.getElementById('new-user-password').value;
        let confirmPassword = document.getElementById('confirm-new-user-password').value;

        let user = new User(username, email, password, confirmPassword);

        let validate = user.validate();

        if(!validate)
        {
            // If the informations are not correct, the form is not submitted
            event.preventDefault();
        }
    })
}

export { validateEditUserForm };