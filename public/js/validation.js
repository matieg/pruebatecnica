const inputsValidate = Array.from(document.querySelectorAll('.validate'));

const validation = () => {
    let isvalid = true;
    inputsValidate.map((input)=> {
        if(input.value == '')
        {
            input.previousElementSibling.classList.remove('d-none')
            input.classList.add('is-invalid')
            isvalid = false;
        }
        else
        {
            input.previousElementSibling.classList.add('d-none')
            input.classList.remove('is-invalid')
        }
    })
    return isvalid;
}