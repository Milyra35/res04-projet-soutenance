import { validateRegisterForm } from './validateRegisterForm.js';
import { collapseData } from './collapseData.js';
import { validateLoginForm } from './validateLoginForm.js';

window.addEventListener("DOMContentLoaded", function() {
    // console.log(window.location.pathname);
    let defaultPath = "/res04-projet-soutenance/";

    if(window.location.pathname.includes(defaultPath + "villagers/"))
    {
        collapseData();
    }
    if(window.location.pathname === defaultPath + "register")
    {
        validateRegisterForm();
    }
    if(window.location.pathname === defaultPath + "login")
    {
        validateLoginForm();
    }
})