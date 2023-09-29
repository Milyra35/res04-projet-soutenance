// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.querySelectorAll('.data td:last-of-type form:last-of-type');
    console.log(editRoleForm);
    
    for(let i=0; i<editRoleForm.length; i++)
    {
        editRoleForm[i].addEventListener('submit', function(event) {
            event.preventDefault();

            // I retrieve the different IDs
            let submit = 'submit-change-role-'+i;
            let id = i;
            let roleId = 1;
    
            // Representation of a form in JS
            let formData = new FormData();
            formData.append(submit, true);
            formData.append('user-id', id);
            formData.append('user-role-id', roleId);
    
            let options = {
                method: 'POST',
                body: formData
            };
    
            fetch('/res04-projet-soutenance/admin/all-users', options)
            .then(function(response)
            {
                if(!response.ok)
                {
                    throw new Error('La réponse du serveur n\'est pas ok');
                }
                return response.json();
            })
            .then(function(data) 
            {
                console.log(data);
                window.location.reload();
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête fetch :', error);
            });
        });
    }
}

export { reloadAllUsers };