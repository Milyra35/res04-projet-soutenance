// To be able to resize the font by clicking on a button

function resizeText()
{
    let increaseBtn = document.querySelector(".font-size button:first-of-type");
    let decreaseBtn = document.querySelector(".font-size button:last-of-type");
    let body = document.querySelector('.user-layout');

    // I want to de define a max and min size of the font
    let maxFont = 26;
    let minFont = 12;

    // Returns the value of the font-size of the body
    let fontSize = parseFloat(getComputedStyle(body).fontSize);

    increaseBtn.addEventListener('click', function() {
        fontSize += 4;

        if(fontSize > maxFont)
        {
            fontSize = maxFont;
        }

        body.style.fontSize = fontSize + "px";
        body.style.lineHeight = 1.8 + "rem";
    });

    decreaseBtn.addEventListener('click', function() {
        fontSize -= 4;

        if(fontSize < minFont)
        {
            fontSize = minFont;
        }
        body.style.fontSize = fontSize + "px";
        body.style.lineHeight = 1.4 + "rem";
    })
}

export { resizeText };