// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.getElementById('file-upload');
    console.log(editRoleForm);
    
    editRoleForm.addEventListener('submit', function(e) {
        e.preventDefault();

        console.log("please work");

        // This is the representation of a form in JS
        let formData = new FormData(editRoleForm);
        formData.append('upload-file', true);
        formData.append('saved-file', document.getElementById('saved-file').value);
        // formData.append('submit-change-role', true);
        // formData.append('user_to_edit_id', document.getElementById('user_to_edit_id').value);
        // formData.append('user_role_id', document.getElementById('user_role_id').value);

        let options = {
            method: 'POST',
            body: formData
        };

        fetch('/res04-projet-soutenance/my-games', options)
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
        .catch(function(error) 
        {
            console.error('Erreur de fetch', error);
        })
    });
}

export { reloadAllUsers };