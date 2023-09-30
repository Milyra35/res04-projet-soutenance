// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.querySelectorAll('.data td:last-of-type form:last-of-type');
    // console.log(editRoleForm);
    
    for(let i=0; i<editRoleForm.length; i++)
    {
        editRoleForm[i].addEventListener('submit', function(event) {
            event.preventDefault();
            let td = document.querySelectorAll('.data td:last-of-type');

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
    
            fetch('all-users', options)
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

                td[i + 1].value = "";
                // window.location.reload();
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête fetch :', error);
            });
        });
    }
}

export { reloadAllUsers };