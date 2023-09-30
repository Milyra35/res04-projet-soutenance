// To be able to resize the font by clicking on a button

function resizeText()
{
    let increaseBtn = document.querySelector(".font-size button:first-of-type");
    let decreaseBtn = document.querySelector(".font-size button:last-of-type");
    let body = document.querySelector('.user-layout');

    // Returns the value of the font-size of the body
    let fontSize = parseFloat(getComputedStyle(body).fontSize);

    increaseBtn.addEventListener('click', function() {
        fontSize += 5;
        body.style.fontSize = fontSize + "px";
        body.style.lineHeight = 1.8 + "rem";
    });

    decreaseBtn.addEventListener('click', function() {
        fontSize -= 5;
        body.style.fontSize = fontSize + "px";
        body.style.lineHeight = 1.4 + "rem";
    })
}

export { resizeText };