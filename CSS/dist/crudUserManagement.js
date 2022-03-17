/**************************************************
 * AJAX : DISPLAY USER
 ***************************************************/
function displayUser()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/userManagement');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText !== "")
			{
				console.log("AJAX : request select completed");
				$("#userList").html(request.responseText);
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : INSERT USER
 ***************************************************/
function insertUser()
{
	const requestType       = "insert";
	const userName          = $('#input-name').val();
	const userDescription   = $('#input-description').val();
	let actionList          = [];
	let permissionList      = $(".input-permission");
	
	for (let i = 0; i < permissionList.length; i++)
	{
		if (permissionList[i].checked)
			actionList.push(permissionList[i].name);
	}
	
	const request = new XMLHttpRequest();
	request.open('POST', '/userManagement');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			console.log("AJAX : request insert completed");
			displayUser();
			closeForm();
		}
	};
	
	console.log(actionList)
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&userName=${userName}&userDescription=${userDescription}&actionList=${actionList}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : DELETE USER
 ***************************************************/
function deleteUser()
{
	const requestType   = "delete";
	let userList        = $(".idUser");
	let userNameList    = [];
	let userIdList      = [];
	
	for (let i = 0; i < userList.length; i++)
	{
		if (userList[i].checked)
		{
			userIdList.push(userList[i].name);
			userNameList.push($("#" + userList[i].name).html());
		}
	}
	
	if(userNameList.length > 0)
	{
		if(confirm(("Etes-vous sûr de vouloir supprimer le(s) rôle(s) : " + userNameList.join(", ") + " ?")))
		{
			const request = new XMLHttpRequest();
			request.open('POST', '/userManagement');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					console.log("AJAX : request delete completed");
					displayUser();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&userIdList=${userIdList}`;
			
			request.send(body);
		}
	}
	else
	{
		alert("Sélectionnez au minimum un rôle à supprimer.");
	}
}

/**************************************************
 * AJAX : OPEN USER FORM
 ***************************************************/
function openForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/userManagement');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText !== "")
			{
				console.log("AJAX : request open form completed");
				$("#ctnUserForm").html(request.responseText);
				$("#ctnUserForm").css("width", "100%");
				$("#ctnUserForm").css("height", "100%");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&userId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE USER FORM
 ***************************************************/
function closeForm()
{
	$("#ctnUserForm").html("");
	$("#ctnUserForm").css("width", "0");
	$("#ctnUserForm").css("height", "0");
}

/**************************************************
 * EVENT LISTENER
 ***************************************************/
$("#userList").ready(displayUser);