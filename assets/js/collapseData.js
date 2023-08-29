function collapseData() 
{
    let title = document.querySelectorAll('.title');
    let events = document.querySelectorAll('.events');

    for(let i=0; i<title.length; i++)
    {
        events[i].style.display = 'none';
        
        title[i].addEventListener("click", function() {

            if(events[i].style.display === 'none' || events[i].style.display === '')
            {
                events[i].style.display = 'table';
            }
            else
            {
                events[i].style.display = 'none';
            }
        })
    }
}

export { collapseData };