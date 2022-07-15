function saveTemplate(param) {

    let template = {
        template: param.textContent
    }

    const requestType = "saveTemplate";

    const request = new XMLHttpRequest();
    request.open('POST', '/template-gestion');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else if (request.responseText === 'success'){
                createNotification('success', 'Modification sauvegarder avec succès');
                window.location.href = "/dashboard";
            } else if (request.responseText === 'error'){
                createNotification('error', 'Sauvegarde impossible');
                window.location.href = "/dashboard";
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&template=${JSON.stringify(template)}`;
    request.send(body);
}