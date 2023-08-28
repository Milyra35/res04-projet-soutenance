import { validateRegisterForm } from './validateRegisterForm.js';
import { collapseData } from './collapseData.js';

window.addEventListener("DOMContentLoaded", function() {
    console.log(window.location.pathname);
    let defaultPath = "/res04-projet-soutenance/";

    if(window.location.pathname.includes(defaultPath + "villagers/"))
    {
        collapseData();
    }
    if(window.location.pathname === defaultPath + "register")
    {
        validateRegisterForm();
    }
})