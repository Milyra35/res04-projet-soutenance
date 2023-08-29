import { User } from './classe/User.js';

function validateLoginForm() 
{
    let loginForm = document.getElementById('login-form');

    loginForm.addEventListener("submit", function(event) {
        // event.preventDefault();

        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        let passwordCode = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@[-`{-~]).{12,}$/;

        if(!passwordCode.test(password))
        {
            let error = document.getElementById('error');
            error.innerHTML = "Invalid informations";
            event.preventDefault();
        }
        else
        {
            let error = document.getElementById('error');
            error.innerHTML = "";
        }
    })
}

export { validateLoginForm };