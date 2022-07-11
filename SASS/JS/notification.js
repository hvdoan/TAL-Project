function displayNotification()
{
    const requestType       = "display"

    const request = new XMLHttpRequest();
    request.open('POST', '/notification');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText !== "")
            {
                $("#alert").html(request.responseText);
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}`;

    request.send(body);
}

function removeNotification()
{
    $("#alert").html("");
}