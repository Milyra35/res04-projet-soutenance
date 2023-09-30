// Create a function to reload the page automatically after i submitted a file

function reloadPage()
{
    let form = document.getElementById('file-upload');
    let list = document.querySelector('.games section ul');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(form);
        console.log(formData);

        let options = {
            method: 'POST',
            body: formData
        };
        
        fetch('my-games', options)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            list.innerHTML = '';

            data.forEach(game => {
                let li = document.createElement('li');
                let a = document.createElement('a');
                a.href = `/res04-projet-soutenance/my-games/${game.name}`;
                a.textContent = game.name;

                li.appendChild(a);
                list.appendChild(li);
            })
        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch', error);
        });
    });
}

export { reloadPage };