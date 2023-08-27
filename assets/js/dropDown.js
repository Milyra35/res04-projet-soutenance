function dropDown() 
{
    let title = document.getElementById('villager-events');
    let events = document.getElementById('events');

    title.addEventListener("click",function() {
        let isVisible = events.style.display !== 'none';

        if(isVisible)
        {
            events.style.display = 'none';
        }
        else
        {
            events.style.display = 'table';
        }
    });
}

export { dropDown };