// Create a function to reload the all users page on the back-office if a change is made

function reloadAllUsers()
{
    let editRoleForm = document.querySelector('#edit-the-role');
    
    editRoleForm.addEventListener("submit", function(event) {
        event.preventDefault();

        console.log("hello");

        let $formData = new FormData();
        $formData.append('user_to_edit_id', document.getElementById('user_to_edit_id').value);
        $formData.append('user_role_id', document.getElementById('user_role_id').value);

        fetch('/res04-projet-soutenance/admin/all-users', {
            method: 'POST',
            body: $formData,
        })
        .then(response => response.json())
        .then(data => {

            let p = document.createElement('p');
            let main = document.querySelector('.all-users');

            p.textContent = "Role changed with success";
            main.appendChild(p);

            console.log(data);
            window.location.reload();
        })
    })
}

export { reloadAllUsers };