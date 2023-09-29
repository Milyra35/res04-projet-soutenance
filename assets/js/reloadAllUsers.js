// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.getElementById('edit-the-role');
    console.log(editRoleForm);
    
    editRoleForm.addEventListener('submit', function(event) {
        event.preventDefault();

        console.log("please work");

        let formName = document.getElementById('form-name').value;
        let id = document.getElementById('user_to_edit_id').value;
        let roleId = document.getElementById('user_role_id').value;

        // Representation of a form in JS
        let formData = new FormData();
        formData.append('form-name', formName);
        formData.append('user-id', id);
        formData.append('role-id', roleId);

        let options = {
            method: 'POST',
            body: formData
        };

        fetch('role-edit', options)
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

            let tr = document.querySelector('tbody .data');
            tr.value = "";
        })
        .catch(function(error) 
        {
            console.error('Erreur fetch', error);
        });
    });
}

export { reloadAllUsers };