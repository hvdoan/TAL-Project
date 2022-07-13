function saveStyle() {
    let style = {};
    let form = document.getElementById('StyleForm');
    let values = form.getElementsByTagName('input');
    for (var i = 0; i < values.length; i++) {
        style[values[i].id] = values[i].value;
    }

    const requestType = "saveStyle";

    const request = new XMLHttpRequest();
    request.open('POST', '/template-save');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else if (request.responseText === 'success'){
                console.log('info');
                createNotification('success', 'Modification sauvegarder avec succès');
                window.location.href = "/dashboard";
            } else if (request.responseText === 'error'){
                createNotification('error', 'Sauvegarde impossible');
                window.location.href = "/dashboard";
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&data=${JSON.stringify(style)}`;
    request.send(body);
}