function collapseData() 
{
    let title = document.querySelectorAll('.title');
    let events = document.querySelectorAll('.events');
    let button = document.querySelectorAll('.title button');

    for(let i=0; i<title.length; i++)
    {
        events[i].style.display = 'none';
        
        title[i].addEventListener("click", function() {

            if(events[i].style.display === 'none' || events[i].style.display === '')
            {
                events[i].style.display = 'table';
                button[i].classList.add('button-focus');
            }
            else
            {
                events[i].style.display = 'none';
                button[i].classList.remove('button-focus');
            }
        })
    }
}

export { collapseData };