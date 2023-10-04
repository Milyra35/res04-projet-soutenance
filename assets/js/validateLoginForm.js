function validateLoginForm() 
{
    let loginForm = document.getElementById('login-form');

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        
        let formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('login', true);
        
        let options = {
            method: 'POST',
            body: formData
        };
        
        fetch('/res04-projet-soutenance/login', options)
        .then(response => response.json())
        .then(data => {
            if(!data.login)
            {
                let wrongInformations = document.getElementById('error');
                wrongInformations.innerHTML = "Invalid informations";
            }
            else
            {
                loginForm.submit();
                
                if(!data.admin)
                {
                    window.location.href = "/res04-projet-soutenance/my-games";
                }
                else 
                {
                    window.location.href = "/res04-projet-soutenance/admin";
                }
            }
        })
        .catch(error => {
            console.error('An error occured: ' + error);
        });
    })
}

export { validateLoginForm };