// Create a dark mode

function darkMode()
{
    let button = document.querySelector(".dark");
    let body = document.querySelector(".user-layout");

    button.addEventListener("click", function() {
        body.classList.toggle('dark-mode');
    })
}

export { darkMode };