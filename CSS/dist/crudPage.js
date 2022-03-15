/**************************************************
 * AJAX : DISPLAY PAGE
 ***************************************************/
function displayPage()
{
    const requestType = "display";

    const request = new XMLHttpRequest();
    request.open('POST', '/pageManagement');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText !== "")
            {
                console.log("AJAX : request display completed");
                $("#pageList").html(request.responseText);
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}`;

    request.send(body);
}

/**************************************************
 * AJAX : UPDATE PAGE
 ***************************************************/
function updateRole(idPage, data)
{
    const requestType = "update";

    const request = new XMLHttpRequest();
    request.open('POST', '/pageCreation');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log("AJAX : request update completed");
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&idPage=${idPage}&data=${data}`;

    request.send(body);
}

/**************************************************
 * EVENT LISTENER
 ***************************************************/
$("#pageList").ready(displayPage);