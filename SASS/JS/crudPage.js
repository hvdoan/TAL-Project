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
            if (request.responseText !== "")
            {
                console.log("AJAX : request display completed");
                $("#pageList").html(request.responseText);

                $(document).ready( function ()
                {
                    $('#pageTable').DataTable();
                } );
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}`;

    request.send(body);
}

/**************************************************
 * AJAX : INSERT ROLE
 ***************************************************/
function insertPage(data)
{
    const requestType       = "insert";
    const pageUri           = $('#input-uri').val();
    const pageDescription   = $('#input-description').val();

    const request = new XMLHttpRequest();
    request.open('POST', '/page-creation');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log("AJAX : request insert completed");
            console.log(request.responseText);
            window.location.href = "/page-management";
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&data=${data}&pageUri=${pageUri}&pageDescription=${pageDescription}`;

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

    const request = new XMLHttpRequest();
    request.open('POST', '/page-creation');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log("AJAX : request update completed");
            window.location.href = "/page-management";
        }
    };

    console.log(pageId);
    console.log(data);

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&pageId=${pageId}&data=${data}&pageUri=${pageUri}&pageDescription=${pageDescription}`;

    request.send(body);
}

/**************************************************
 * AJAX : DELETE ROLE
 ***************************************************/
function deletePage()
{
    const requestType   = "delete";
    let pageList        = $(".idPage");
    let pageUriList    = [];
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
                    console.log("AJAX : request delete completed");
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

/**************************************************
 * EVENT LISTENER
 ***************************************************/
$("#pageList").ready(displayPage);