function search(searchString)
{
    const requestType = "search";

    const request = new XMLHttpRequest();
    request.open('POST', '/search');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            $("#searchResultContainer").html(request.responseText);
            console.log(request.responseText)
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&searchString=${searchString}`;
    request.send(body);
}

function delay(fn, ms) {
    let timer = 0
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}