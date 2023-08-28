function filter() 
{
    let inputValue = document.getElementById('search').value;
    let arrayData = document.querySelectorAll('.data');
    let submit = document.getElementById('search-box');

    submit.addEventListener("click", function() {
        for(let i=0; i<arrayData.length; i++)
        {
            if(arrayData[i].textContent.toLowerCase().includes(inputValue))
            {
                arrayData[i].style.fontWeight = "bold";
                console.log(inputValue);
            }
            else
            {
                arrayData[i].style.display = "none";
            }
        }
    })
}

export { filter };