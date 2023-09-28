import { validateRegisterForm } from './validateRegisterForm.js';
import { validateLoginForm } from './validateLoginForm.js';
import { validateEditForm } from './validateEditForm.js';
import { collapseData } from './collapseData.js';
import { filter } from './filter.js';
import { reloadAllUsers } from './reloadAllUsers.js';
import { reloadPage } from './reloadPage.js';

window.addEventListener("DOMContentLoaded", function() {
    let defaultPath = "/res04-projet-soutenance/";

    // I want to load only specific functions on specific pages
    if(window.location.pathname.includes(defaultPath + "villagers/") || window.location.pathname.includes(defaultPath + "my-games/"))
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
    if(window.location.pathname === defaultPath + "admin/all-users" || window.location.pathname === defaultPath + "villagers")
    {
        if(window.location.pathname === defaultPath + "admin/all-users")
        {
            reloadAllUsers();
        }
        filter();
    }
    if(window.location.pathname === defaultPath + "admin/edit")
    {
        validateEditForm();
    }
    // if(window.location.pathname === defaultPath + "my-games")
    // {
    //     reloadPage();
    // }
    
})