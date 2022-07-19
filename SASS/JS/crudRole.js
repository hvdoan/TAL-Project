/**************************************************
* AJAX : DISPLAY ROLE
***************************************************/
function displayRole()
{
    const requestType = "display";

    const request = new XMLHttpRequest();
    request.open('POST', '/role-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                $("#roleList").html(request.responseText);

                $(document).ready( function ()
                {
                    $('#roleTable').DataTable();
                });
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
    const tokenForm         = $('#tokenForm').val();
    let actionList          = [];
    let permissionList      = $(".input-permission");

    for (let i = 0; i < permissionList.length; i++)
    {
        if (permissionList[i].checked)
            actionList.push(permissionList[i].name);
    }

    const request = new XMLHttpRequest();
    request.open('POST', '/role-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                displayRole();
                closeRoleForm();
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&tokenForm=${tokenForm}&roleName=${roleName}&roleDescription=${roleDescription}&actionList=${actionList}`;

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
    const tokenForm         = $('#tokenForm').val();
    let actionList          = [];
    let permissionList      = $(".input-permission");

    for (let i = 0; i < permissionList.length; i++)
    {
        if (permissionList[i].checked)
            actionList.push(permissionList[i].name);
    }

    const request = new XMLHttpRequest();
    request.open('POST', '/role-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                displayRole();
                closeRoleForm();
            }
        }
    };

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const body = `requestType=${requestType}&tokenForm=${tokenForm}&roleId=${roleId}&roleName=${roleName}&roleDescription=${roleDescription}&actionList=${actionList}`;

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
            request.open('POST', '/role-management');

            request.onreadystatechange = function()
            {
                if(request.readyState === 4)
                {
                    if (request.responseText === "login")
                        window.location.href = "/login";
                    else
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
function openRoleForm(id = "")
{
    const requestType = "openForm";
    let ctnRoleForm = $("#ctnRoleForm");

    const request = new XMLHttpRequest();
    request.open('POST', '/role-management');

    request.onreadystatechange = function()
    {
        if(request.readyState === 4)
        {
            if (request.responseText === "login")
                window.location.href = "/login";
            else
            {
                ctnRoleForm.html(request.responseText);
                ctnRoleForm.css("width", "300%");
                ctnRoleForm.css("height", "300%");
                $("body").addClass("overflowHidden");
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
function closeRoleForm()
{
    let ctnRoleForm = $("#ctnRoleForm");

    ctnRoleForm.html("");
    ctnRoleForm.css("width", "0");
    ctnRoleForm.css("height", "0");
    $("body").removeClass("overflowHidden");
}

function checkAll(self)
{
    $(".idRole").prop("checked", $(self).prop("checked"));
}