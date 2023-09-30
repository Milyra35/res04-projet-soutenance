function test()
{
    fetch('/res04-projet-soutenance/admin/statistics')
    .then(response => response.json())
    .then(data => {
        console.log(data);
    });
}

export { test };