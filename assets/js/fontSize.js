// To be able to resize the font by clicking on a button

function resizeText()
{
    let increaseBtn = document.querySelector(".font-size button:first-of-type");
    let decreaseBtn = document.querySelector(".font-size button:last-of-type");
    let body = document.querySelector('.user-layout');

    // Returns the value of the font-size of the body
    let fontSize = parseFloat(getComputedStyle(body).fontSize);

    increaseBtn.addEventListener('click', function() {
        fontSize += 4;
        body.style.fontSize = fontSize + "px";
        // body.style.lineHeight = 1.8 + "rem";

        // To prevent the buttons from moving, I have to define a default font-size for them
        increaseBtn.style.fontSize = 1.1 + "rem";
        decreaseBtn.style.fontSize = 0.9 + "rem";
    });

    decreaseBtn.addEventListener('click', function() {
        fontSize -= 4;
        body.style.fontSize = fontSize + "px";
        // body.style.lineHeight = 1.4 + "rem";

        increaseBtn.style.fontSize = 1.1 + "rem";
        decreaseBtn.style.fontSize = 0.9 + "rem";
    })
}

export { resizeText };