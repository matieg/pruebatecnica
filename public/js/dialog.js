let dialog = document.getElementById('favDialog');
const openDialog = (message) => {
    dialog.querySelector("#messageDialog").innerHTML = message
    const form = event.target;
    dialog.showModal();
    dialog.addEventListener('close', () => {
        if(dialog.returnValue){
            return form.submit();
        }
    })
    return false;
}