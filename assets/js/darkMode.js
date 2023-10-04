// Create a dark mode

function darkMode()
{
    let button = document.querySelector(".dark");
    let body = document.querySelector(".user-layout");

    // I want to see if the dark mode is already in the local storage
    let isDarkMode = localStorage.getItem("darkMode") === "true";

    if(isDarkMode)
    {
        // If isDarkMode is in the local storage, i add the class dark-mode
        body.classList.add('dark-mode');
    }

    // And when i click on the button, i change the state of the dark mode
    button.addEventListener("click", function() {
        body.classList.toggle('dark-mode');

        if(body.classList.contains('dark-mode'))
        {
            localStorage.setItem('darkMode', true); // I store the bool of darkmode so that when i change page, it stays on light or dark mode
        }
        else 
        {
            localStorage.setItem('darkMode', false);
        }
    });
}

export { darkMode };