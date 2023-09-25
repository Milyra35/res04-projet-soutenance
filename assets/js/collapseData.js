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
                title[i].classList.add('button-focus');
            }
            else
            {
                events[i].style.display = 'none';
                title[i].classList.remove('button-focus');
            }
        })

        // title[i].addEventListener("click", function() {
        //     if(events[i].classList.contains('open'))
        //     {
        //         events[i].classList.remove('open');
        //     }
        //     else 
        //     {
        //         events[i].classList.add('open');
        //     }
        // });
    }
}

export { collapseData };

