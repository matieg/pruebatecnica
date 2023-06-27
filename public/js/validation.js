const inputsValidate = Array.from(document.querySelectorAll('.validate'));

const validation = () => {
    let isvalid = true;
    inputsValidate.map((input)=> {
        if(input.value == '')
        {
            input.previousElementSibling.classList.remove('d-none')
            input.classList.add('is-invalid')
            isvalid = false;
        } else
        {
            input.previousElementSibling.classList.add('d-none')
            input.classList.remove('is-invalid')
        }
    })
    return isvalid;
}

const inputsValidatePassword = Array.from(document.querySelectorAll('.validate-password'));
const validationPassword = () => {
    let isValid = validation();
    const newpassword = document.querySelector('#newpassword');
    const repeatpassword = document.querySelector('#repeatpassword');
    if (newpassword.value !== repeatpassword.value) {
        
        newpassword.previousElementSibling.classList.remove('d-none')
        newpassword.classList.add('is-invalid')
        newpassword.previousElementSibling.innerHTML = "Las contraseñas no coinciden"
        
        repeatpassword.previousElementSibling.classList.remove('d-none')
        repeatpassword.classList.add('is-invalid')
        repeatpassword.previousElementSibling.innerHTML = "Las contraseñas no coinciden"
        isValid = false;
    }else{
        inputsValidatePassword[1].previousElementSibling.innerHTML = "Campo requerido."
        repeatpassword.previousElementSibling.innerHTML = "Campo Requerido."
        // isValid = true;
    }
    return isValid;
}
  