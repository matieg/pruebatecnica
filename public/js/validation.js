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
    if (inputsValidatePassword[1].value !== inputsValidatePassword[2].value) {

        inputsValidatePassword[1].previousElementSibling.classList.remove('d-none')
        inputsValidatePassword[1].classList.add('is-invalid')
        inputsValidatePassword[1].previousElementSibling.innerHTML = "Las contraseñas no coinciden"
        
        inputsValidatePassword[2].previousElementSibling.classList.remove('d-none')
        inputsValidatePassword[2].classList.add('is-invalid')
        inputsValidatePassword[2].previousElementSibling.innerHTML = "Las contraseñas no coinciden"
        isValid = false;
    }else{
        inputsValidatePassword[1].previousElementSibling.innerHTML = "Campo requerido."

        inputsValidatePassword[2].previousElementSibling.innerHTML = "Campo Requerido."
        isValid = true;
    }
    console.log(isValid);
    return false;
}
  