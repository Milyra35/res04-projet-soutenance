function collapseData() 
{
    let title = document.getElementById('villager-events');
    let events = document.getElementById('events');

    title.addEventListener("click",function() {
        let isHidden = events.style.display === 'none';

        if(isHidden)
        {
            events.style.display = 'table';
        }
        else
        {
            events.style.display = 'none';
        }
    });
}

export { collapseData };