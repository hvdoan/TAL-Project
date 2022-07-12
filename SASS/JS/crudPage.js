/**************************************************
 * AJAX : DISPLAY PAGE
 ***************************************************/
function displayPage()
{
    const requestType = "display";

    const request = new XMLHttpRequest();
    request.open('POST', '/page-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                $("#pageList").html(request.responseText);

                $(document).ready( function ()
                {
                    $('#pageTable').DataTable();
                });
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}`;
    request.send(body);
}

/**************************************************
 * AJAX : INSERT PAGE
 ***************************************************/
function insertPage(data)
{
    const requestType       = "insert";
    const pageUri           = $('#input-uri').val();
    const pageDescription   = $('#input-description').val();
    const tokenForm         = $('#tokenForm').val();

    const request = new XMLHttpRequest();
    request.open('POST', '/page-creation');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else if(request.responseText === "success") {
                createNotification('success', 'Page créer avec succès');
                window.location.href = "/page-management";
            }
            else if(request.responseText === "error")
                displayNotification();
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&tokenForm=${tokenForm}&data=${data}&pageUri=${pageUri}&pageDescription=${pageDescription}`;

    request.send(body);
}

/**************************************************
 * AJAX : UPDATE PAGE
 ***************************************************/
function updatePage(pageId, data)
{
    const requestType       = "update"
    const pageUri           = $('#input-uri').val();
    const pageDescription   = $('#input-description').val();
    const tokenForm         = $('#tokenForm').val();

    const request = new XMLHttpRequest();
    request.open('POST', '/page-creation');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else if(request.responseText === "success") {
                createNotification('success', 'Page sauvegarder avec succès');
                window.location.href = "/page-management";
            }
            else if(request.responseText === "error")
                displayNotification();
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&tokenForm=${tokenForm}&pageId=${pageId}&data=${data}&pageUri=${pageUri}&pageDescription=${pageDescription}`;

    request.send(body);
}

/**************************************************
 * AJAX : DELETE PAGE
 ***************************************************/
function deletePage()
{
    const requestType   = "delete";
    let pageList        = $(".idPage");
    let pageUriList     = [];
    let pageIdList      = [];

    for (let i = 0; i < pageList.length; i++)
    {
        if (pageList[i].checked)
        {
            pageIdList.push(pageList[i].name);
            pageUriList.push($("#" + pageList[i].name).html());
        }
    }

    if(pageUriList.length > 0)
    {
        if(confirm(("Etes-vous sûr de vouloir supprimer la ou les pages : " + pageUriList.join(", ") + " ?")))
        {
            const request = new XMLHttpRequest();
            request.open('POST', '/page-management');

            request.onreadystatechange = function()
            {
                if(request.readyState === 4)
                {
                    if (request.responseText === "login")
                        window.location.href = "/login";
                    else
                        displayPage();
                }
            };

            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            const body = `requestType=${requestType}&pageIdList=${pageIdList}`;

            request.send(body);
        }
    }
    else
    {
        alert("Sélectionnez au minimum une page à supprimer.");
    }
}
