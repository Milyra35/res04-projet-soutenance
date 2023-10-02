import { User } from './classe/User.js';

function validateEditUserForm()
{
    let editForm = document.getElementById('edit-user-form');
    let isValid = true;

    editForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let username = document.getElementById('new-user-username').value;
        let email = document.getElementById('new-user-email').value;
        let password = document.getElementById('new-user-password').value;
        let confirmPassword = document.getElementById('confirm-new-user-password').value;

        let user = new User(username, email, password, confirmPassword);
        let validate = user.validate();

        if(!validate)
        {
            isValid = false;
        }
        else
        {
            let formData = new FormData();
            formData.append('username', username);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('confirm-password', confirmPassword);
            formData.append('submit-edit-user', true);

            let options = {
                method: 'POST',
                body: formData
            };

            fetch('/res04-projet-soutenance/my-account/edit', options)
            .then(response => response.json())
            .then(data => {
                if(data.exists)
                {
                    let errorUsername = document.querySelector('.errorUsername'); // I show the error if the username already exists
                    errorUsername.textContent = "This username already exists";
                    isValid = false;
                }
                else 
                {
                    isValid = true;
                    editForm.submit();
                    window.location.href = "/res04-projet-soutenance/my-account";
                }
            })
            .catch(error => {
                console.error('An error occured: ' + error);
            });
        }
    });
}

export { validateEditUserForm };