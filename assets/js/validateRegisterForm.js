import { User } from './classe/User.js';

function validateRegisterForm()
{
    let submitRegisterForm = document.getElementById('submit-new-user');

    submitRegisterForm.addEventListener("click", function(event) {
        // event.preventDefault();

        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm-password').value;

        let user = new User(username, email, password, confirmPassword);

        if(user.validate())
        {
            user.validate();
        }
        else
        {
            event.preventDefault();
        }
        // user.validate();
    })
}

export { validateRegisterForm };