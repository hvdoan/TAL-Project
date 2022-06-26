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