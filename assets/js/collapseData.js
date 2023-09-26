function collapseData() 
{
    let title = document.querySelectorAll('.title');
    let events = document.querySelectorAll('.events');

    for(let i=0; i<title.length; i++)
    {
        events[i].style.display = 'none';
        title[i].innerHTML = title[i].textContent + " ↓";
        
        title[i].addEventListener("click", function() {

            if(events[i].style.display === 'none' || events[i].style.display === '')
            {
                events[i].style.display = 'table';
                title[i].classList.add('button-focus');
                title[i].innerHTML = title[i].textContent.replace(" ↓", " ↑"); // I replace the arrow when i clicked on it
            }
            else
            {
                events[i].style.display = 'none';
                title[i].classList.remove('button-focus');
                title[i].innerHTML = title[i].textContent.replace(" ↑", " ↓");
            }
        })
    }
}

export { collapseData };

