// Create a function to reload the page automatically after i submitted a file

function reloadPage()
{
    let form = document.getElementById('file-upload');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche la soumission par défaut du formulaire
    
        let formData = new FormData();
    
        fetch('/res04-projet-soutenance/my-games', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('La réponse du serveur n\'est pas ok');
            }
            return response.json(); // Attend une réponse JSON
        })
        .then(function(data) {
            console.log(data); // Affiche la réponse JSON reçue du serveur
    
            // Si le serveur retourne une indication de succès (par exemple, un champ "success" dans la réponse JSON),
            // vous pouvez recharger la page :
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(function(error) {
            console.error('Erreur de fetch', error);
        });
    });
}

export { reloadPage };