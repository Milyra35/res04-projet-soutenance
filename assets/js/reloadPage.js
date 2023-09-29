// Create a function to reload the page automatically after i submitted a file

function reloadPage()
{
    let submit = document.getElementById('upload-file');

    submit.addEventListener('click', function(e) {
        window.location.reload(true);
    
    });
}

export { reloadPage };