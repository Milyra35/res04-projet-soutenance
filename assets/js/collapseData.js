function collapseData() 
{
    let title = document.querySelectorAll('.title');
    let events = document.querySelectorAll('.events');

    for(let i=0; i<title.length; i++)
    {
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
    // events.style.display = 'none';

    // title.addEventListener("click",function() {
    //     let isHidden = events.style.display === 'none';

    //     if(isHidden)
    //     {
    //         events.style.display = 'table';
    //     }
    //     else
    //     {
    //         events.style.display = 'none';
    //     }
    // });
}

export { collapseData };