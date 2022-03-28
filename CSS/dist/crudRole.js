/**************************************************
* AJAX : DISPLAY ROLE
***************************************************/
function displayRole()
{
    const requestType = "display";

    const request = new XMLHttpRequest();
    request.open('POST', '/roleManagement');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText !== "")
            {
                console.log("AJAX : request display completed");
                $("#roleList").html(request.responseText);

                $(document).ready( function ()
                {
                    $('#roleTable').DataTable({
                        "ordering": false
                    });
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
function insertRole()
{
    const requestType       = "insert";
    const roleName          = $('#input-name').val();
    const roleDescription   = $('#input-description').val();
    let actionList          = [];
    let permissionList      = $(".input-permission");

    for (let i = 0; i < permissionList.length; i++)
    {
        if (permissionList[i].checked)
            actionList.push(permissionList[i].name);
    }

    const request = new XMLHttpRequest();
    request.open('POST', '/roleManagement');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log("AJAX : request insert completed");
            displayRole();
            closeForm();
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&roleName=${roleName}&roleDescription=${roleDescription}&actionList=${actionList}`;

    request.send(body);
}

/**************************************************
 * AJAX : UPDATE ROLE
 ***************************************************/
function updateRole()
{
    const requestType       = "update";
    const roleId            = $('#input-id').val();
    const roleName          = $('#input-name').val();
    const roleDescription   = $('#input-description').val();
    let actionList          = [];
    let permissionList      = $(".input-permission");

    for (let i = 0; i < permissionList.length; i++)
    {
        if (permissionList[i].checked)
            actionList.push(permissionList[i].name);
    }

    const request = new XMLHttpRequest();
    request.open('POST', '/roleManagement');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            console.log("AJAX : request insert completed");
            displayRole();
            closeForm();
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&roleId=${roleId}&roleName=${roleName}&roleDescription=${roleDescription}&actionList=${actionList}`;

    request.send(body);
}

/**************************************************
 * AJAX : DELETE ROLE
 ***************************************************/
function deleteRole()
{
    const requestType   = "delete";
    let roleList        = $(".idRole");
    let roleNameList    = [];
    let roleIdList      = [];

    for (let i = 0; i < roleList.length; i++)
    {
        if (roleList[i].checked)
        {
            roleIdList.push(roleList[i].name);
            roleNameList.push($("#" + roleList[i].name).html());
        }
    }

    if(roleNameList.length > 0)
    {
        if(confirm(("Etes-vous sûr de vouloir supprimer le(s) rôle(s) : " + roleNameList.join(", ") + " ?")))
        {
            const request = new XMLHttpRequest();
            request.open('POST', '/roleManagement');

            request.onreadystatechange = function()
            {
                if(request.readyState === 4)
                {
                    console.log("AJAX : request delete completed");
                    displayRole();
                }
            };

            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            const body = `requestType=${requestType}&roleIdList=${roleIdList}`;

            request.send(body);
        }
    }
    else
    {
        alert("Sélectionnez au minimum un rôle à supprimer.");
    }
}

/**************************************************
 * AJAX : OPEN ROLE FORM
 ***************************************************/
function openForm(id = "")
{
    const requestType = "openForm";

    const request = new XMLHttpRequest();
    request.open('POST', '/roleManagement');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText !== "")
            {
                console.log("AJAX : request open form completed");
                $("#ctnRoleForm").html(request.responseText);
                $("#ctnRoleForm").css("width", "100%");
                $("#ctnRoleForm").css("height", "100%");
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&roleId=${id}`;

    request.send(body);
}

/**************************************************
 * CLOSE ROLE FORM
 ***************************************************/
function closeForm()
{
    $("#ctnRoleForm").html("");
    $("#ctnRoleForm").css("width", "0");
    $("#ctnRoleForm").css("height", "0");
}

/**************************************************
 * EVENT LISTENER
 ***************************************************/
$("#roleList").ready(displayRole);

function checkAll(self)
{
    $(".idRole").prop("checked", $(self).prop("checked"));
}