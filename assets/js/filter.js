function filter() 
{
    let input = document.getElementById('search');
    let username = document.querySelectorAll('.data-row');
    let arrayData = document.querySelectorAll('.data');

    input.addEventListener("input", function() {
        // All the characters will be in lower case
        let inputValue = input.value.toLowerCase();

        for(let i=0; i<arrayData.length; i++)
        {
            // Same for the characters'/users' name
            let text = username[i].textContent.toLowerCase();

            if(text.indexOf(inputValue) > -1) // Because it's an array
            {
                arrayData[i].style.display = "";
            }
            else
            {
                arrayData[i].style.display = "none";
            }
        }
    })
}

export { filter };