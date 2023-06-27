let dialog = document.getElementById('dialog');
const openDialog = (message) => {
    dialog.querySelector("#messageDialog").innerHTML = message
    dialog.showModal();
    const form = event.target;
    dialog.addEventListener('close', () => {
        if(dialog.returnValue){
            return form.submit();
        }
    })
    return false;
}
const openDialogButton = (message, url) => {
    dialog.querySelector("#messageDialog").innerHTML = message
    dialog.showModal();
    dialog.addEventListener('close', () => {
        if(dialog.returnValue){
            return window.location.href = url;
        }
    })
    return false;
}