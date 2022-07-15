function saveStyle() {

    let form = document.getElementById('StyleForm');
    let values = form.getElementsByTagName('input');
    let dataDecode = JSON.parse(document.getElementById('jsonHidden').textContent);

    for (const property in dataDecode) {
        for (const property2 in dataDecode[property]) {
            for (let i = 0; i < values.length; i++) {
                if (values[i].id === property2) {
                    dataDecode[property][property2]['value'] = values[i].value;
                }
            }
        }
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
                createNotification('success', 'Modification sauvegarder avec succès');
                window.location.href = "/dashboard";
            } else if (request.responseText === 'error'){
                createNotification('error', 'Sauvegarde impossible');
                window.location.href = "/dashboard";
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&data=${JSON.stringify(dataDecode)}`;
    request.send(body);
}