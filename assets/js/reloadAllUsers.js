// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.getElementById('edit-the-role');
    
    editRoleForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        let formData = new FormData(editRoleForm);

        fetch('http://helloworld/res04-projet-soutenance/admin/all-users', {
            method: 'POST',
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            window.location.reload();
        })
    })
}

export { reloadAllUsers };