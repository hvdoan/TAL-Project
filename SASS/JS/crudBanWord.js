function displayBanWord()
{
    console.log('test');
    const requestType = "display";

    const request = new XMLHttpRequest();
    request.open('POST', '/ban-word-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                $("#banWordList").html(request.responseText);

                $(document).ready(function (){
                    $('#banWordTable').DataTable();
                });
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}`;
    request.send(body);
}

function insertBanWord()
{
    const requestType      = "insert";
    const banWordIdMessage = $('#input-message').val();
    const tokenForm        = $('#tokenForm').val();

    const request = new XMLHttpRequest();
    request.open('POST', '/ban-word-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log(request.responseText);
            if (request.responseText === "login")
                window.location.href = "/login";
            else
                window.location.href = "/ban-word-management";
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&tokenForm=${tokenForm}&banWord=${banWordIdMessage}`;

    request.send(body);
}

function updateBanWord()
{
    const requestType      = "update";
    const banWordId        = $('#input-id').val();
    const banWord          = $('#input-message').val();
    const tokenForm        = $('#tokenForm').val();

    const request = new XMLHttpRequest();
    request.open('POST', '/ban-word-management');

    request.onreadystatechange = function(){
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                window.location.href = "/ban-word-management";
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');const body = `requestType=${requestType}&tokenForm=${tokenForm}&banWordId=${banWordId}&banWord=${banWord}`;
    request.send(body);
}

function deleteBanWord(){
    const requestType   = "delete";
    let banWordList        = $(".idBanWord");
    let banWordNameList    = [];
    let banWordIdList      = [];

    for (let i = 0; i < banWordList.length; i++){
        if (banWordList[i].checked){
            banWordIdList.push(banWordList[i].name);
            banWordNameList.push($("#" + banWordList[i].name)[0].name);
        }
    }

    if(banWordNameList.length > 0){
        if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) mot(s) : ${banWordNameList.join(", ")} ainsi que toutes ses dépendances ?`))){
            const request = new XMLHttpRequest();
            request.open('POST', '/ban-word-management');

            request.onreadystatechange = function()
            {
                if(request.readyState === 4)
                {
                    if (request.responseText === "login")
                        window.location.href = "/login";
                    else
                        window.location.href = "/ban-word-management";
                }
            };

            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            const body = `requestType=${requestType}&banWordIdList=${banWordIdList}`;

            request.send(body);
        }
    }else{
        alert("Sélectionnez au minimum un mot à supprimer.");
    }
}

function openBanWordForm(id = "")
{
    const requestType = "openForm";

    const request = new XMLHttpRequest();
    request.open('POST', '/ban-word-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                $("#ctnMessageForm").html(request.responseText);
                $("#ctnMessageForm").css("width", "100%");
                $("#ctnMessageForm").css("height", "100%");
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&banWordId=${id}`;

    request.send(body);
}