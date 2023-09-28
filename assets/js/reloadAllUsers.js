// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.getElementById('edit-the-role');
    console.log(editRoleForm);
    
    editRoleForm.addEventListener('submit', function(e) {
        e.preventDefault();

        console.log("please work");

        // This is the representation of a form in JS
        let formData = new FormData();
        formData.append('submit-change-role', true);
        formData.append('user_to_edit_id', document.getElementById('user_to_edit_id').value);
        formData.append('user_role_id', document.getElementById('user_role_id').value);

        let options = {
            method: 'POST',
            body: formData
        };

        fetch('role-edit', options)
        .then(function(response)
        {
            return response.json();
        })
        .then(function(data) 
        {
            console.log(data);
            window.location.reload();
        });
    });
}

export { reloadAllUsers };