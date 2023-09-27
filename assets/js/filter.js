function filter() 
{
    let input = document.getElementById('search');
    let username = document.querySelectorAll('.data-row');
    let arrayData = document.querySelectorAll('.data');

    input.addEventListener("input", function() {
        let inputValue = input.value.toLowerCase();

        for(let i=0; i<arrayData.length; i++)
        {
            let text = username[i].textContent.toLowerCase();

            if(text.indexOf(inputValue) > -1)
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