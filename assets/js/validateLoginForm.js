import { User } from './classe/User.js';

function validateLoginForm() 
{
    let submitLoginForm = document.getElementById('login');

    submitLoginForm.addEventListener("click", function(event) {
        event.preventDefault();

        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        let passwordCode = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@[-`{-~]).{12,}$/;

        if(!passwordCode.test(password))
        {
            let error = document.getElementById('error');
            error.innerHTML = "Invalid informations";
        }
        else
        {
            let error = document.getElementById('error');
            error.innerHTML = "";
        }
    })
}

export { validateLoginForm };