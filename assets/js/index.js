import { validateRegisterForm } from './validateRegisterForm.js';
import { collapseData } from './collapseData.js';
import { validateLoginForm } from './validateLoginForm.js';
import { filter } from './filter.js';

window.addEventListener("DOMContentLoaded", function() {
    // console.log('hello');
    let defaultPath = "/res04-projet-soutenance/";

    if(window.location.pathname.includes(defaultPath + "villagers/") || this.window.location.pathname.includes(defaultPath + "my-games/"))
    {
        collapseData();
    }
    if(window.location.pathname === defaultPath + "register")
    {
        validateRegisterForm();
    }
    if(window.location.pathname === defaultPath + "login")
    {
        // validateLoginForm();  
    }
    if(window.location.pathname === defaultPath + "admin/all-users" || window.location.pathname === defaultPath + "villagers")
    {
        filter();
    }
})