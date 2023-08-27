export class User {
    #username;
    #email;
    #password;
    #confirmPassword;
    #errors;

    constructor(username, email, password, confirmPassword, errors = [])
    {
        this.#username = username;
        this.#email = email;
        this.#password = password;
        this.#confirmPassword = confirmPassword;
        this.#errors = errors;
    }

    get username()
    {
        return this.#username;
    }
    set username(username)
    {
        this.#username = username;
    }

    get email()
    {
        return this.#email;
    }
    set email(email)
    {
        this.#email = email;
    }

    get password()
    {
        return this.#password;
    }
    set password(password)
    {
        this.#password = password;
    }

    get confirmPassword()
    {
        return this.#confirmPassword;
    }
    set confirmPassword(confirmPassword)
    {
        this.#confirmPassword = confirmPassword;
    }

    get errors()
    {
        return this.#errors;
    }
    set errors(errors)
    {
        this.#errors = errors;
    }

    validateUsername(nameList)
    {
        if(this.username.length >= 4 && this.username.length <= 64)
        {
            let username = document.getElementById('errorUsername');
            username.innerHTML = "";
            return true;
        }
        else if(nameList.includes(this.username))
        {
            let username = document.getElementById('errorUsername');
            username.innerHTML = "This username already exists";
            this.addError("username", "This username already exists");
            return false;
        }
        else
        {
            let username = document.getElementById('errorUsername');
            username.innerHTML = "The username has to be between 4 and 64 characters";
            this.addError("username", "The username has to be between 4 and 64 characters");
            return false;
        }
    }

    validateEmail()
    {
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(emailPattern.test(this.email))
        {
            let email = document.getElementById('errorEmail');
            email.innerHTML = "";
            return true;
        }
        else
        {
            let email = document.getElementById('errorEmail');
            email.innerHTML = "The email is not valid";
            this.addError("email", "The email is not valid");
            return false;
        }
    }

    validatePassword()
    {
        let passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@[-`{-~]).{12,}$/;

        if(this.password === this.confirmPassword && passwordPattern.test(this.password))
        {
            let password = document.getElementById('errorPassword');
            password.innerHTML = "";
            return true;
        }
        else if(this.password !== this.confirmPassword)
        {
            let password = document.getElementById('errorPassword');
            password.innerHTML = "Both password have to be the same";
            this.addError("password", "Both password have to be the same");
            return false;
        }
        else
        {
            let password = document.getElementById('errorPassword');
            password.innerHTML = "The password has to include 1 uppercase letter, 1 number, 1 special character and at least 12 characters.";
            this.addError("password", "The password has to include 1 uppercase letter, 1 number, 1 special character and at least 12 characters.");
            return false;
        }
    }

    addError(field, error)
    {
        this.errors.push({field, error});
    }

    resetErrors()
    {
        this.errors = [];
    }

    validate()
    {
        if(this.validateUsername() === true && this.validateEmail() === true && this.validatePassword() === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}